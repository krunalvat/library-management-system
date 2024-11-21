@extends('layouts.app')
@section('content')
  <div class="container mt-4">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Borrowing Books Feature</h3>
      </div>
      <form 
        action="{{ route('store.borrow.data') }}" 
        method="POST" 
        enctype="multipart/form-data" 
        class="needs-validation" 
        novalidate>
        @csrf
        <div class="card">
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input 
                  type="name" 
                  id="name" 
                  name="name" 
                  value="{{ old('title') }}" 
                  class="form-control" 
                   />
                @error('name')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-md-6">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input 
                  type="email" 
                  id="email" 
                  name="email" 
                  value="{{ old('title') }}" 
                  class="form-control" 
                   />
                @error('email')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-md-6">
                <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                <input 
                  type="tel" 
                  id="phone_number" 
                  name="phone_number" 
                  value="{{ old('phone_number') }}" 
                  class="form-control" 
                   />
                @error('phone_number')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-md-6">
                <label for="book_id" class="form-label">Book <span class="text-danger">*</span></label>
                <select 
                  id="book_id" 
                  name="book_id" 
                  class="form-select">
                  <option value="">Select Book</option>
                  @foreach($books as $key => $value)
                    <option value="{{ $key }}" 
                      {{ old('book_id') == $key ? 'selected' : '' }}>
                      {{ $value }}
                    </option>
                  @endforeach
                </select>
                @error('book_id')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-md-6">
                <label for="borrowed_at" class="form-label">Borrowed At <span class="text-danger">*</span></label>
                <input 
                  type="date" 
                  id="borrowed_at" 
                  name="borrowed_at" 
                  value="{{ old('borrowed_at') }}" 
                  class="form-control" 
                  required />
                @error('borrowed_at')
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
