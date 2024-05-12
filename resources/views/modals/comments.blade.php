<div class="modal fade" id="comments-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Комментарии</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="comments-array">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="modal-footer">
                <div class="m-3">
                    <form id="post-comment" data-commentable-type data-commentable-id action="////////" enctype="multipart/form-data" method="POST">
                        @csrf
                        @if($errors->any())
                            {!! implode('', $errors->all('<div style="color:red;">:message</div>')) !!}
                        @endif
                        <div id="create-post-form" class="d-flex">
                            <div class="form-group">
                                <textarea required name="text" class="form-control" id="text-comment" rows="3"></textarea>
                            </div>
                            <div class="d-flex flex-row-reverse mt-3">
                                <button type="submit" class="btn btn-primary">Отправить</button>
                                <div class="form-group">
                                    <div class="file-input">
                                        <input
                                                multiple
                                                type="file"
                                                name="images[]"
                                                id="file-input-comment"
                                                class="file-input__input"
                                        />
                                        <label class="file-input__label" for="file-input-comment">
                                            @include('app.svg.clip')
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>