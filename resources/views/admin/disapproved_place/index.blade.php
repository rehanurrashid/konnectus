@extends('admin.layouts.app')

@section('title', 'Denied Places')

@push('before-styles')
    <style>
        .margbg{
            margin:5px;
            display: inline-block;
            position: center;
        }
    </style>
    <link href="{{ asset('admin/css/layout.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('after-scripts')
    <script src="{{ asset('admin/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('admin/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/tables/datatables/extensions/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('admin/js/myapp.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('admin/js/demo_pages/datatables_extension_buttons_html5.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
    <script src="{{ asset('admin/js/demo_pages/form_multiselect.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/visualization/d3/d3_tooltip.js') }}"></script>
    <script src="{{ asset('admin/js/demo_pages/dashboard.js') }}"></script>
@endpush

@section('content')
    @include('admin.includes.navbar')
    <!-- Page content -->
    <div class="page-content" style="margin-top: 0px; ">
        <!-- Main sidebar -->
    @include('admin.includes.sidebar')
        <!-- /main sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
                @include('admin.includes.pageheader')
            <!-- /page header -->


            <!-- Content area -->
            <div class="content">


                <!-- Dashboard content -->
                <div class="row">
                    <div class="col-xl-12">

                        <!-- /quick stats boxes -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    @if(Session::has('message'))
                                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row note-message d-none">
                            <div class="col-lg-12">
                                <div>
                                    <p class="alert alert-success">Note Added Successfully!</p>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <div class="card">
                                        <div class="card-header header-elements-inline">
                                            <h5 class="card-title">Denied Places List</h5>

                                            <div class="header-elements">
                                                <div class="list-icons">
                                                    <a class="list-icons-item" data-action="collapse"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table" id="rtable">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Get Direction</th>
                                                <th>User Name</th>
                                                <th>Location Name</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Rate</th>
                                                <th>Total Reviews</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    @push('after-scripts')
                                        <script>
                                            $(function() {
                                                $('#rtable').DataTable({
                                                    processing: true,
                                                    serverSide: true,
                                                    autoWidth: false,
                                                    responsive: true,
                                                    ajax: '{!! route('disapproved_places.index') !!}',
                                                    columns: [
                                                        { data: 'id', name: 'id' },
                                                        { data: 'direction', name: 'direction' },
                                                        { data: 'user_name', name: 'user_name' },
                                                        { data: 'name', name: 'name' },
                                                        { data: 'phone', name: 'phone' },
                                                        { data: 'status', name: 'status' },
                                                        { data: 'rate', name: 'rate' },
                                                        { data: 'reviews', name: 'reviews' },
                                                        {data: 'action', name: 'action', orderable: false, searchable: false}
                                                    ],
                                                    buttons: {
                                                        dom: {
                                                            button: {
                                                                className: 'btn btn-light'
                                                            }
                                                        },
                                                        buttons: [
                                                            'copyHtml5',
                                                            'excelHtml5',
                                                            'csvHtml5',
                                                            'pdfHtml5'

                                                        ],
                                                        'columnDefs': [
                                                            {
                                                                "className": "dt-center", "targets": "_all"
                                                            }
                                                        ],
                                                    }

                                                });
                                            });
                                        </script>
                                @endpush
                                <!-- /basic initialization -->


                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <!-- /dashboard content -->
            </div>
            <!-- /content area -->
<script type="text/javascript">
    $(document).ready(function(){


        $(document).on( "click", ".delete-row", function() {
          let id = $( this ).next('p').text() ;
          $('.confirm').attr('href','javascript:sdelete("admin/places/'+id+'")');
          $(document).on("click", ".confirm", function(){
            $('#exampleModal').modal('toggle');
          })
        });

// Add the notes

    var host = "{{URL::to('/')}}";
    var place_id = '';
    var notes = '';

    $(document).on('click', '.open-note-modal', function(){

       let place_id = $( this ).parents('div.btn-group').find('p.place-id').text();
       let notes = $( this ).parents('div.btn-group').find('p.notes').text();

       $('#place-id-modal').text(place_id)

       if(notes != ''){

        $('.note-title').text('Update Note')
        $('.submit-note').text('Update Note')
        $('#notes').val(notes)

       }
       else{

        $('.note-title').text('Add Note')
        $('.submit-note').text('Add Note')
        $('#notes').val(notes)
       }

    });

    $(document).on('click', '.submit-note', function(event){
        event.preventDefault();

        var notes = $('#notes').val();
        let place_id = $('#place-id-modal').text();

        if(notes == ''){
            $('#notes-error').removeClass('d-none');
            $('#notes').css("border","1px solid #D75A4A");//more efficient
        }
        else{

            $.ajax({
               type: "POST",
               url: '{{route("add.place.note")}}',
               data: {"_token": "{{ csrf_token() }}", place_id:place_id, notes:notes},
               success: function( response ) {

                  if(response.status == true){
                    
                    var table = $('#rtable').DataTable();
 
                    table.ajax.reload( function ( json ) {
                        return true;
                    } );

                    $('#notesModal').modal('toggle');
                    $('.note-message').removeClass('d-none')
                  }

               },
               error: function(response){

                alert('error')

               }
           });
        }

    })

    })
</script>

            <!-- Footer -->
            @include('admin.includes.footer')
            <!-- /footer -->

        </div>
        <!-- /main content -->

    </div>
@endsection
