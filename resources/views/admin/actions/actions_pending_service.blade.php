@if(isset($service))
    @if(!$service->trashed())
    <div class="btn-group" role="group" aria-label="Basic example">
        <a href="{{ route('pending_services.edit', [$service->id]) }}" title="Edit Service"><i class="icon-pencil5 mr-1 icon-1x"></i></a>
        <a href="javascript:sdelete('admin/pending_services/{{$service->id}}')" title="Suspend Service" class="delete-row delete-color" data-id="{{ $service->id }}"><i class="icon-bin mr-1 icon-1x" style="color:red;"></i></a>
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
