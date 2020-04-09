@if(isset($place))
    @if(!$place->trashed())
    <div class="btn-group" role="group" aria-label="Basic example">
        <a href="{{ route('places.edit', [$place->id]) }}" title="Edit Place"><i class="icon-pencil5 mr-1 icon-1x"></i></a>
        <a href="javascript:sdelete('admin/places/{{$place->id}}')" title="Suspend Place" class="delete-row delete-color" data-id="{{ $place->id }}"><i class="icon-bin mr-1 icon-1x" style="color:red;"></i></a>
        <a href="{{ route('places.show', [$place->id]) }}" title="View Place" class="delete-row delete-color" data-id="{{ $place->id }}">
            <img src="{{asset('images/eye.png')}}" width="25px">
        </a>
    </div>
    @else
    <div class="btn-group" role="group" aria-label="Basic example">
        <a href="javascript:restore('places/restore/{{$place->id}}')" title="Restore Place" class="restore-row restore-color" data-id="{{ $place->id }}"><i
                class="icon-loop3"></i></a>
        <a href="javascript:permanent('places/deletePermanently/{{$place->id}}')" title="Delete Permanently" class="delete-permanently-row delete-color" data-id="{{ $place->id }}"><i
                class="icon-cancel-square2" style="color: red;"></i></a>
     </div>
    @endif
@endif
