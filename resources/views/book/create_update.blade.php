@extends('layouts.app')
@section('content')
  <div class="container mt-4">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">{{ isset($book) ? __('Update Book') : __('Create Book') }}</h3>
      </div>
      <form 
        action="{{ isset($book) ? route('books.update', $book->id) : route('books.store') }}" 
        method="POST" 
        enctype="multipart/form-data" 
        class="needs-validation" 
        novalidate>
        @csrf
        @if(isset($book))
          @method('PATCH')
        @endif
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Form Elements</h5>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                <input 
                  type="text" 
                  id="title" 
                  name="title" 
                  value="{{ old('title', $book->title ?? '') }}" 
                  class="form-control" 
                   />
                @error('title')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-md-6">
                <label for="isbn" class="form-label">ISBN<span class="text-danger">*</span></label>
                <input 
                  type="text" 
                  id="isbn" 
                  name="isbn" 
                  value="{{ old('isbn', $book->isbn ?? '') }}" 
                  class="form-control" 
                   />
                @error('isbn')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-md-6">
                <label for="author_id" class="form-label">Author <span class="text-danger">*</span></label>
                <select 
                  id="author_id" 
                  name="author_id" 
                  class="form-select" 
                  required>
                  <option value="">Select Author</option>
                  @foreach($authors as $key => $value)
                    <option value="{{ $key }}" 
                      {{ old('author_id', $book->author_id ?? '') == $key ? 'selected' : '' }}>
                      {{ $value }}
                    </option>
                  @endforeach
                </select>
                @error('author_id')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-md-6">
                <label for="published_date" class="form-label">Published Date <span class="text-danger">*</span></label>
                <input 
                  type="date" 
                  id="published_date" 
                  name="published_date" 
                  value="{{ old('published_date', isset($book->published_date) ? $book->published_date : '') }}" 
                  class="form-control" 
                  required />
                @error('published_date')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>              
              <div class="col-md-6">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select id="status" name="status" class="form-select" required>
                  <option value="available" 
                    {{ old('status', $book->status ?? 'available') === 'available' ? 'selected' : '' }}>
                    Available
                  </option>
                  <option value="borrowed" 
                    {{ old('status', $book->status ?? '') === 'borrowed' ? 'selected' : '' }}>
                    Borrowed
                  </option>
                </select>
                @error('status')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
          </div>
          <div class="card-footer d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('books.index') }}" class="btn btn-danger ms-2">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection