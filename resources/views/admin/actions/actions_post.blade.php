@if(isset($post))
    @if(!$post->trashed())
    <div class="btn-group" role="group" aria-label="Basic example">
        <a href="{{ route('posts.edit', [$post->id]) }}" title="Edit Post"><i class="icon-pencil5 mr-1 icon-1x"></i></a>
        <a href="javascript:sdelete('admin/posts/{{$post->id}}')" title="Suspend Post" class="delete-row delete-color" data-id="{{ $post->id }}"><i class="icon-bin mr-1 icon-1x" style="color:red;"></i></a>
        <a href="{{ route('posts.show', [$post->id]) }}" title="View User Details" class="delete-row delete-color" data-id="{{ $post->id }}">
            <i class="fa fa-eye text-info" aria-hidden="true"></i>
        </a>
    </div>
    @else
    <div class="btn-group" role="group" aria-label="Basic example">
        <a href="javascript:restore('posts/restore/{{$post->id}}')" title="Restore Post" class="restore-row restore-color" data-id="{{ $post->id }}"><i
                class="icon-loop3"></i></a>
        <a href="javascript:permanent('posts/deletePermanently/{{$post->id}}')" title="Delete Permanently" class="delete-permanently-row delete-color" data-id="{{ $post->id }}"><i
                class="icon-cancel-square2" style="color: red;"></i></a>
     </div>
    @endif
@endif
