@extends('admin.layouts.app')

@section('title', 'Approved Service Details')

@push('before-styles')
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
                @include('admin.includes.pageheader');
            <!-- /page header -->


            <!-- Content area -->
            <div class="content">
                <div class="row note-message d-none">
                    <div class="col-lg-12">
                        <div>
                            <p class="alert alert-success">Note Added Successfully!</p>
                        </div>
                    </div>
                </div>

                <!-- Dashboard content -->
                <div class="row">
                    <div class="col-xl-12">

                        <!-- /quick stats boxes -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header header-elements-inline">
                                            <h6 class="card-title">Service Details</h6>
                                            <div class="header-elements">
                                                <div class="list-icons">
                                                    <a class="list-icons-item" data-action="collapse"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                	<h4 class="float-right">User Name: </h4>
                                                </div>
                                                <div class="col">
                                                	<h4 class="d-inline">{{$service->user->name}}</h4>
                                                    <img data-toggle="modal" data-target="#notesModal"  src="{{asset('images/note.jpg')}}" width="8%" class="float-right mr-4 open-note-modal" style="cursor: pointer;">
                                                    <p class="notes d-none">{!!$service->notes!!}</p>
                                                    <p class="service-id d-none" >{!!$service->id!!}</p>
                                                </div>
                                            </div>
                                            <hr>
											<div class="row">
                                                <div class="col-md-3">
                                                	<h4 class="float-right">Category: </h4>
                                                </div>
                                                <div class="col">
                                                	<h4>{{$service->category->name}}</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                	<h4 class="float-right">Service Name </h4>
                                                </div>
                                                <div class="col">
                                                	<h4>{{$service->name}}</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                	<h4 class="float-right">Address: </h4>
                                                </div>
                                                <div class="col">
                                                	<h4>{{$service->address}}</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                	<h4 class="float-right">Phone: </h4>
                                                </div>
                                                <div class="col">
                                                	<h4>{{$service->phone}}</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                	<h4 class="float-right">Status </h4>
                                                </div>
                                                <div class="col">
                                                	<h4>
                                                		Approved
                                                		&nbsp; &nbsp; &nbsp;
                                                		<a href="{{ route('services.edit', [$service->id]) }}" title="Change Status"><i class="icon-pencil5 mr-1 icon-1x"></i></a>
                                                	</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <h4 class="float-right">Rating: </h4>
                                                </div>
                                                <div class="col">
                                                    <h4>{{$service->avg_rate}}</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <h4 class="float-right">Total Reviews: </h4>
                                                </div>
                                                <div class="col">
                                                    <h4>{{$service->rating_count}}</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <h4 class="float-right">Spoken Languages: </h4>
                                                </div>
                                                <div class="col">
                                                    <h4>{{ (!empty($place->language_code)) ? $place->language_code : 'No Languages'}}</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                	<h4 class="float-right">Tags: </h4>
                                                </div>
                                                <div class="col">
                                                	<h4>{{ (!empty($service->tags)) ? $service->tags : 'No Tags'}}</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <h4 class="float-right">Image: </h4>
                                                </div>
                                                <div class="col">
                                                    @forelse($service->photos as $photo)
                                                    <img src="{{$photo->photo }}" alt="Location Image" width="40%" class="img-thumbnail">
                                                    @empty
                                                    <h4>No Images Uploaded Yet!</h4>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

    // Add the notes

    var service_id = '';
    var notes = '';

    $(document).on('click', '.open-note-modal', function(){

       let service_id = $( this ).parents('div').find('p.service-id').text();

       let notes = $( this ).parents('div').find('p.notes').text();

       $('#service-id-modal').text(service_id)

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
        let service_id = $('#service-id-modal').text();

        if(notes == ''){

            $('#notes-error').removeClass('d-none');
            $('#notes').css("border","1px solid #D75A4A");//more efficient
        }
        else{
            // alert(service_id);

            $.ajax({
               type: "POST",
               url: '{{route("add.service.note")}}',
               data: {"_token": "{{ csrf_token() }}", service_id:service_id, notes:notes},
               success: function( response ) {

                
                  if(response.status == true){

                    $('p.notes').text(response.data.notes);

                    $('#notesModal').modal('toggle');
                    $('.note-message').removeClass('d-none')
                  }

               },
               error: function(response){

                console.log(response)

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
<!-- Add Notes Modal -->
<div class="modal fade" id="notesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title note-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <textarea name="notes" id="notes" class="form-control" rows="4" cols="50" placeholder="Write here..."></textarea>
        <label id="notes-error" class="d-none ml-1"  style="color: #D75A4A">
          <strong>Notes field must be filled!</strong>
        </label>
        <p id="service-id-modal" class="d-none"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a  href="" class="btn btn-danger submit-note">
          
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
