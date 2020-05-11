
@if(isset($token))
    <div class="btn-group" role="group" aria-label="Basic example">
        <a href="{{ route('pending_services.show', [$service->id]) }}" title="View Service" class="delete-row delete-color" data-id="{{ $service->id }}" target="_blank">
            {{$service->name}}
        </a>
    </div>
@else
    @if(isset($service))
        @if(!$service->trashed())
        <div class="btn-group" role="group" aria-label="Basic example">

          <a data-toggle="modal" data-target="#notesModal" style="cursor: pointer;" class="mr-2 open-note-modal" title="Add Note">
              <i class="fa fa-sticky-note-o fa-1x" aria-hidden="true" class="text-success"></i>
            </a>
            <p class="notes d-none">{!!$service->notes!!}</p>
            
            <a href="{{ route('pending_services.edit', [$service->id]) }}" title="Edit Service"><i class="icon-pencil5 mr-1 icon-1x"></i></a>

            <a data-toggle="modal" data-target="#exampleModal" style="cursor: pointer;" title="Suspend Service" class="delete-row delete-color" data-id="{{ $service->id }}"><i class="icon-bin mr-1 icon-1x" style="color:red;"></i></a>
            <p class="service-id d-none">{!!$service->id!!}</p>

            <a href="{{ route('pending_services.show', [$service->id]) }}" title="View Service" class="delete-row delete-color" data-id="{{ $service->id }}">
                <i class="fa fa-eye text-info" aria-hidden="true"></i>
            </a>
        </div>
        @else
        <div class="btn-group" role="group" aria-label="Basic example">
            <a href="javascript:restore('pending_services/restore/{{$service->id}}')" title="Restore Service" class="restore-row restore-color" data-id="{{ $service->id }}"><i
                    class="icon-loop3"></i></a>
            <a href="javascript:permanent('pending_services/deletePermanently/{{$service->id}}')" title="Delete Permanently" class="delete-permanently-row delete-color" data-id="{{ $service->id }}"><i
                    class="icon-cancel-square2" style="color: red;"></i></a>
         </div>
        @endif
    @endif
@endif

<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Alert!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a  href="" class="btn btn-danger confirm">Confirm</a>
      </div>
    </div>
  </div>
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