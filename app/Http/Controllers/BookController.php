<?php

namespace App\Http\Controllers;

use App\Models\book;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\BookHistoryController;
use App\Models\BookHistory;


class BookController extends Controller
{

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            // Pastikan kolom 'status' disertakan dalam select()
            $data = Book::select(['id', 'penerbit', 'penulis', 'judul', 'stock', 'status']);
    
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('voting', function($row) {
                    return '<i class="fa-regular fa-heart"></i>';
                })
                ->addColumn('action', function($row) {
                    $btn = '';
                
                    if (auth()->user()->role === 'admin') {
                        $btn .= '<a href="' . route('book.edit', $row->id) . '">
                                    <button class="btn btn-sm btn-warning">Edit</button>
                                 </a>';
                        $btn .= ' <form action="' . route('book.destroy', $row->id) . '" method="POST" style="display:inline;">
                                      ' . csrf_field() . '
                                      ' . method_field('DELETE') . '
                                      <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                  </form>';
                    }
                
                    if (auth()->user()->role === 'user') {
                        if ($row->stock > 0) {
                            $btn .= '<a href="' . route('book.libary', $row->id) . '">
                                        <button class="btn btn-sm btn-success">Pinjam buku</button>
                                     </a>';
                        } else {
                            $btn .= '<button class="btn btn-sm btn-danger" disabled>Buku Kosong</button>';
                        }
                    }
                
                    return $btn;
                })
                ->rawColumns(['action','voting'])
                ->make(true);
        }
    
        return view('books.index');
    }
    
    
    /**
     * Display a listing of the resource.
     */

     public function __construct()
     {
         $this->middleware('auth');
     }
    public function index()
    {
        //
        $books = book::all();
        return view('index', compact('books'));
        
    }

    /**~
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'penerbit' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'judul' => 'required|string|max:255',

            'status' => 'nullable|in:dibooking,dipinjam,dikembalikan',
            'stock' => 'numeric|integer',
        ]);

        // Simpan data ke database
        Book::create([

            'penerbit' => $request->penerbit,
            'penulis' => $request->penulis,
            'judul' => $request->judul,
            'peminjam' => null,
            'tgl_pinjam' => null,
            'status' => $request->status,
            'stock' => $request->stock,
        ]);

        // Redirect ke halaman tertentu dengan pesan sukses
        return redirect()->route('index')->with('add', 'Buku berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $books = book::where('id', $id)->first();
        return view('edit', compact('books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, book $book, $id)
    {
        $request->validate([
            'penerbit' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'penulis' => 'nullable|string|max:255',
            
        ]);

        $books = book::findOrFail($id);



        Book::where('id', $id)->update([
            'penerbit' => $request->penerbit,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
        ]);

        return redirect()->route('book.index')->with('update', 'Berhasil memperbarui data pinjaman 😁');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book, $id)
    {
        // Cari buku berdasarkan ID
        Book::where('id', $id)->delete();

        return redirect()->back()->with('delete', 'Berhasil menghapus data');
    }
    

    public function libary($id)
    {
        $books = book::where('id', $id)->first();
        return view('libary', compact('books'));
    }

    public function addLibary(Request $request, $id){
        $request->validate([
            'peminjam' => 'nullable|string|max:255',
            'tgl_pinjam' => 'nullable|date',
            'status' => 'required|in:dibooking,dipinjam,dikembalikan',
        ]);
    
        $book = Book::findOrFail($id);
        $userId = auth()->id();
        $user = auth()->user();
    
        // Cek apakah user sudah meminjam buku dengan judul yang sama
        $existingBook = Book::where('judul', $book->judul)
                            ->where('peminjam', $user->name)
                            ->whereIn('status', ['dibooking', 'dipinjam'])
                            ->first();
    
        if ($existingBook) {
            return redirect()->back()->with('error', 'Anda sudah membooking atau meminjam buku yang sama');
        }
    
        // Cek jumlah buku yang sudah dipinjam atau dibooking oleh user
        $totalBooks = Book::where('peminjam', $user->name)
                          ->whereIn('status', ['dibooking', 'dipinjam'])
                          ->count();
    
        if ($totalBooks >= 3) {
            return redirect()->back()->with('error', 'Maksimal hanya bisa meminjam atau membooking satu Buku!');
        }
    
        // Kurangi stok buku jika status adalah 'dibooking' atau 'dipinjam'
        if ($request->status === 'dibooking' || $request->status === 'dipinjam') {
            if ($book->stock > 0) {
                $book->stock -= 1;
            } else {
                return redirect()->back()->with('error', 'Stok buku habis!');
            }
        }
    
        // Simpan tanggal peminjaman
        $tgl_pinjam = ($request->status === 'dibooking' || $request->status === 'dipinjam') 
            ? ($request->tgl_pinjam ?? now())
            : null;
    
        $book->update([
            'peminjam' => $user->name,
            'tgl_pinjam' => $tgl_pinjam,
            'status' => $request->status,
            'updated_by' => $userId,
            'stock' => $book->stock,
        ]);
    
        // Simpan riwayat peminjaman
        BookHistory::create([
            'book_id' => $book->id,
            'user_id' => $userId,
            'status' => $request->status,
            'tgl_pinjam' => $tgl_pinjam,
        ]);
    
        return redirect()->route('book.index')->with('update', 'Success menyiapkan buku 😁');
    }

    public function bukusaya(){
        $userId = auth()->id(); // ID pengguna yang sedang login
        $books = Book::where('updated_by', $userId)
                     ->whereIn('status', ['dipinjam', 'dibooking'])
                     ->select(['id', 'penerbit', 'penulis', 'judul', 'peminjam', 'tgl_pinjam', 'status'])
                     ->get();
        return view('bukusaya', compact('books'));
    }



    public function riwayatPeminjaman()
    {
        if (auth()->user()->role === 'admin') {
            $histories = BookHistory::whereHas('book')->with('book')->orderBy('tgl_pinjam', 'desc')->get();
        } else {
            $userId = auth()->id();
            $histories = BookHistory::where('user_id', $userId)
                ->whereHas('book')
                ->with('book')
                ->orderBy('tgl_pinjam', 'desc')
                ->get();
        }
    
        return view('riwayatPeminjaman', compact('histories'));
    }
    



    public function return($id)
    {
        $book = Book::findOrFail($id);
    
        // Pastikan buku sedang dipinjam oleh user yang sedang login
        if ($book->peminjam === auth()->user()->name && $book->status === 'dipinjam') {
            // Simpan tgl_pinjam sebelum dihapus
            $tglPinjamSebelumnya = $book->tgl_pinjam;
    
            // Tambah stok buku
            $book->stock += 1;
    
            // Update status, informasi peminjam, dan tanggal pengembalian
            $book->update([
                'peminjam' => null,
                'tgl_pinjam' => null,
                'tgl_kembali' => now(),
                'status' => 'dikembalikan',
                'stock' => $book->stock,
            ]);
    
            // Simpan riwayat pengembalian dengan tgl_pinjam sebelumnya
            BookHistory::create([
                'book_id' => $book->id,
                'user_id' => auth()->id(),
                'status' => 'dikembalikan',
                'tgl_pinjam' => $tglPinjamSebelumnya,
                'tgl_kembali' => now(),
            ]);
    
            // Redirect dengan alert untuk menanyakan apakah ingin memberikan feedback
            return redirect()->route('book.confirmFeedback', $book->id)->with('success', 'Buku ' . $book->judul . ' berhasil dikembalikan, apakah ingin memberikan feedback?');
        }
    
        return redirect()->route('book.bukusaya')->with('error', 'Anda tidak dapat mengembalikan buku ini.');
    }

    public function confirmFeedback($id)
    {
        $book = Book::findOrFail($id);
        return view('confirmFeedback', compact('book'));
    }
    

    

    public function StatusDipinjam(Request $request, $id)
    {
        $request->validate([
            'tgl_pinjam' => 'required|date', // Wajib memasukkan tanggal peminjaman
        ]);
    
        $book = Book::findOrFail($id);
    
        // Pastikan buku sedang dibooking oleh user yang sedang login
        if ($book->status === 'dibooking' && $book->peminjam === auth()->user()->name) {
            $book->update([
                'status' => 'dipinjam',
                'tgl_pinjam' => $request->tgl_pinjam, // Gunakan tanggal yang diinput
            ]);
    
            return redirect()->route('book.index')->with('success', 'Status buku berhasil diubah menjadi dipinjam!');
        }
    
        return redirect()->route('book.index')->with('error', 'Anda tidak dapat mengubah status buku ini.');
    }

    public function restore($id)
    {
        $book = Book::withTrashed()->find($id);
        if ($book && $book->trashed()) {
            $book->restore();
            return redirect()->route('book.index')->with('success', 'Buku dikembalikan!');
        }
        return redirect()->route('book.index')->with('error', 'Buku tidak ditemukan atau tidak dihapus!');
    }

    public function forcedelete($id)
    {
        $book = Book::withTrashed()->find($id);
        if ($book && $book->trashed()) {
            $book->forceDelete();
            return redirect()->route('book.index')->with('Berhasil','buku dihapus permanen!');
        }
        return redirect()->route('book.index')->with('error', 'Buku tidak ditemukan atau tidak dihapus!');
    }

    public function history()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini!');
        }
    
        $books = Book::onlyTrashed()->get();
        return view('history', compact('books'));
    }

    
}





