@extends('layouts.app')
@section('content')
  <div class="container mt-5">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
          @if(session('success'))
              <div class="alert alert-success">
                  {{ session('success') }}
              </div>
          @endif
            <div class="card-header d-flex align-items-center justify-content-between">
              <h4 class="card-title">Books</h4>
              <div class="d-flex gap-2">
                <a href="{{ route('books.create')}}" class="btn btn-primary btn-round">
                  <i class="fa fa-plus"></i> Add
                </a>
                <a href="{{ route('borrowing.book')}}" class="btn btn-primary btn-round">
                  <i class="fa fa-book"></i> Borrowing Book
                </a>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="yajra-datatables" class="display table table-striped table-hover" style="width: 100%;">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Title</th>
                      <th>ISBN</th>
                      <th>Author Name</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="modal_delete_warning" class="modal fade" tabindex="-1">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header bg-warning">
                  <h6 class="modal-title">Warning!!</h6>
                  <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
              </div>

              <div class="modal-body">
                  <h6 class="font-weight-semibold">Are you sure you want to delete this record ?</h6>
              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn bg-warning modal-delete-confirm">Delete</button>
              </div>
          </div>
      </div>
  </div>

  <div id="modal_for_view" class="modal fade" tabindex="-1">
      <div class="modal-dialog">
          <div class="modal-content bg-teal-300 view-table-bg">
              <div class="modal-header">
                  <h5 class="modal-title">Details</h5>
                  <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
              </div>

              <div class="modal-body">
                  <table class="table table_for_view">
                      <tbody  id="modal-table-data">

                      </tbody>
                  </table>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-link text-white" data-bs-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
@endsection
@section('scripts')
  <script>
    $(document).ready(function () {
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      var table= $('#yajra-datatables').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
          url: '{!! route('books.data') !!}',
        },
        columns: [
          { data: 'DT_RowIndex', name: 'id', orderable: true, searchable: false },
          { data: 'title', name: 'title', searchable: true},
          { data: 'isbn', name: 'isbn', searchable: true },
          { data: 'author_id', name: 'author_id',searchable: true },
          { data: 'status', name: 'status' },
          { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        drawCallback: function (settings) {
          $('#yajra-datatables tbody tr').addClass('border-top table-hover-tr');
        }
      });

      $('body').on('click','.modal-popup-delete',function () {
          var del_url = $(this).data('url');
          $('.modal-delete-confirm').attr('data-url',del_url);
          $('#modal_delete_warning').modal('show');
      });

      $('body').on('click','.modal-delete-confirm',function () {
          var del_url = $(this).attr('data-url');
          $.ajax({
              url: del_url,
              type: 'DELETE',  // user.destroy
              success: function(result) {
                  $('#modal_delete_warning').modal("hide");
                  table.ajax.reload();
              }
          });
      });

      $('body').on('click','.modal-popup-view',function () {
          var view_url = $(this).data('url');
          $.get({
              url:view_url,
              success:function (data) {
                  var view_html = '';
                  $.each(data,function(k,v){
                      view_html +='<tr><td>'+k+'</td><th>'+v+'</th></tr>';
                  });
                  $('#modal-table-data').html(view_html);
                  $('#modal_for_view').modal('show');
              }
          })
      });
    });
  </script>
@endsection