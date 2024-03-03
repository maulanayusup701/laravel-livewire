<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Books extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $gambar;
    public $judul;
    public $penulis;
    public $tahun_terbit;
    public $update = false;

    public $book_id;
    public $search;

    public $role = [
        'judul' => 'required',
        'penulis' => 'required',
        'tahun_terbit' => 'required',
        'gambar' => 'nullable|image|max:1024',
    ];

    public $pesan = [
        'judul.required' => 'Judul wajib diisi',
        'penulis.required' => 'Penulis wajib diisi',
        'tahun_terbit.required' => 'Tahun terbit wajib diisi',
        'gambar.image' => 'file harus gambar',
        'gambar.max' => 'ukuran gambar terlalu besar'
    ];

    public function store(){
        $validated = $this->validate($this->role, $this->pesan);
        if($this->gambar){
            $validated['gambar'] = $this->gambar->store('book-images');
        }
        Book::create($validated);
        session()->flash('success', 'Data berhasil ditambahkan');

        $this->clear();
    }

    public function edit($id){
        $book = Book::find($id);
        $this->gambar = $book->gambar;
        $this->judul = $book->judul;
        $this->penulis = $book->penulis;
        $this->tahun_terbit = $book->tahun_terbit;

        $this->update = true;
        $this->book_id = $id;
    }

    public function updatebook(){

        $validated = $this->validate($this->role, $this->pesan);
        $book = Book::find($this->book_id);
        
        if ($this->gambar) {
            if ($book->gambar) {
                Storage::delete($book->gambar);
            }
            $validated['gambar'] = $this->gambar->store('book-images');
        }
        $book->update($validated);
        session()->flash('success', 'Data berhasil diubah');

        $this->clear();
    }

    public function clear(){
        $this->reset(['gambar', 'judul', 'penulis', 'tahun_terbit']);
        $this->update = false;
        $this->book_id = null;
    }

    public function destroy_confirm($id){
        $this->book_id = $id;
    }

    public function destroy(){
        $id = $this->book_id;
        Book::find($id)->delete(); 
        session()->flash('success', 'Data berhasil di hapus');

        $this->clear();
    }

    public function render()
    {
        $this->search != null ? $books = Book::where('judul', 'like', '%'.$this->search.'%')
        ->orWhere('penulis', 'like', '%'.$this->search.'%')
        ->orWhere('tahun_terbit', 'like', '%'.$this->search.'%')
        ->orderBy('judul', 'asc')->paginate(5)
        : $books = Book::orderBy('judul', 'asc')->paginate(5);

        return view('livewire.books', [
            'books'  => $books
        ]);
    }

}
