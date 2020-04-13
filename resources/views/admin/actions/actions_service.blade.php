@if(isset($service))
    @if(!$service->trashed())
    <div class="btn-group" role="group" aria-label="Basic example">
        <a href="{{ route('services.edit', [$service->id]) }}" title="Edit Service"><i class="icon-pencil5 mr-1 icon-1x"></i></a>
        <a href="javascript:sdelete('admin/services/{{$service->id}}')" title="Suspend Service" class="delete-row delete-color" data-id="{{ $service->id }}"><i class="icon-bin mr-1 icon-1x" style="color:red;"></i></a>
        <a href="{{ route('services.show', [$service->id]) }}" title="View Service" class="delete-row delete-color" data-id="{{ $service->id }}">
            <img src="{{asset('images/eye.png')}}" width="25px">
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
