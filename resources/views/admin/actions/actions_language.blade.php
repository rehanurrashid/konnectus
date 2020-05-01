@if(isset($language))
    @if(!$language->trashed())
    <div class="btn-group" role="group" aria-label="Basic example">
        <a href="{{ route('languages.edit', [$language->id]) }}" title="Edit Language"><i class="icon-pencil5 mr-1 icon-1x"></i></a>
        <a href="javascript:sdelete('admin/languages/{{$language->id}}')" title="Suspend Language" class="delete-row delete-color" data-id="{{ $language->id }}"><i class="icon-bin mr-3 icon-1x" style="color:red;"></i></a>
    </div>
    @else
    <div class="btn-group" role="group" aria-label="Basic example">
        <a href="javascript:restore('languages/restore/{{$language->id}}')" title="Restore Language" class="restore-row restore-color" data-id="{{ $language->id }}"><i
                class="icon-loop3"></i></a>
        <a href="javascript:permanent('languages/deletePermanently/{{$language->id}}')" title="Delete Permanently" class="delete-permanently-row delete-color" data-id="{{ $language->id }}"><i class="icon-cancel-square2" style="color: red;"></i></a>
     </div>
     
    @endif
@endif
