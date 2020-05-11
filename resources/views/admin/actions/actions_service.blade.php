
@if(isset($token))
    <div class="btn-group" role="group" aria-label="Basic example">
        <a href="{{ route('services.show', [$service->id]) }}" title="View Service" class="delete-row delete-color" data-id="{{ $service->id }}" target="_blank">
            {{$service->name}}
        </a>
    </div>
@else
    @if(isset($service))
        @if(!$service->trashed())
        <div class="btn-group" role="group" aria-label="Basic example">
            <a href="{{ route('services.edit', [$service->id]) }}" title="Edit Service"><i class="icon-pencil5 mr-1 icon-1x"></i></a>

            <a data-toggle="modal" data-target="#exampleModal" style="cursor: pointer;" title="Suspend Service" class="delete-row delete-color" data-id="{{ $service->id }}"><i class="icon-bin mr-1 icon-1x" style="color:red;"></i></a>
            <p class="d-none">{!!$service->id!!}</p>

            <a href="{{ route('services.show', [$service->id]) }}" title="View Service" class="delete-row delete-color" data-id="{{ $service->id }}">
                <i class="fa fa-eye text-info" aria-hidden="true"></i>
            </a>
        </div>
        @else
        <div class="btn-group" role="group" aria-label="Basic example">
            <a href="javascript:restore('services/restore/{{$service->id}}')" title="Restore Service" class="restore-row restore-color" data-id="{{ $service->id }}"><i
                    class="icon-loop3"></i></a>
            <a href="javascript:permanent('services/deletePermanently/{{$service->id}}')" title="Delete Permanently" class="delete-permanently-row delete-color" data-id="{{ $service->id }}"><i
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
