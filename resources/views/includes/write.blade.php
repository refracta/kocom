<script src="{{asset('js/ckeditor.js')}}"></script>

<form id="post" role="form" class="form-horizontal" name="" method="post" action="{{route('posts.create')}}"
      enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="content" value="" name="content">
    <input type="hidden" value="{{$board->name}}" name="board_name">
    @if($modify)
        <input type="hidden" value="{{$modify->id}}" name="modify">
    @endif
    <div class="panel panel-default">
        <div class="panel-heading">
            <div>
                <strong style="color: white">{{$board->alias}} 게시판 글쓰기</strong>
            </div>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="title" class="col-sm-1 hidden-xs">제목</label>
                <div class="col-xs-12 col-sm-11">
                    <input class="form-control" name="title" id="title" itemname="제목" pattern=".{2,}" required=""
                           value="@if($modify){{$modify->title}}@else @endif" title="제목은 2글자 이상이어야 합니다."
                           placeholder="제목">
                    <div style="padding-top: 20px">
                        <div id="editor">@if($modify)
                                {!! $modify->content !!}
                            @else @endif</div>
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label class="col-sm-1 hidden-xs"></label>
                <div class="col-xs-12 col-sm-11">
                <span class="pull-right" style="margin-top:10px;">
                    <button type="submit" class="btn btn-success" onclick="$('#content').val(editor.getData())"
                            id="btn_submit">작성</button>
                    &nbsp;&nbsp;&nbsp;
                    <a class="btn btn-default" href="{{route('board', $board->name)}}">목록</a>
                </span>
                </div>
            </div>


            <div class="form-group">
                <label class="col-xs-1 hidden-xs">파일 </label>
                <div class="col-xs-12 col-sm-11">
                    <a class="btn btn-default btn-xs" onclick="addFile();" style="cursor:pointer;"
                       title="add file/첨부파일 입력창 1개 추가"><i class="fa fa-plus"></i></a>&nbsp;&nbsp;
                    <a class="btn btn-default btn-xs" onclick="deleteFile();" style="cursor:pointer;"
                       title="delete file/첨부파일 입력창 1개 삭제"><i class="fa fa-minus"></i></a> <br>
                    <table id="variableFiles" class="table table-condensed"
                           style="word-break:break-all;overflow:hidden;table-layout:fixed">
                        <tbody>
                        </tbody>
                    </table>
                    <script type="text/javascript">
                        var fileLength = 0;
                        @if($modify)
                        let json = JSON.parse(`{!! $modify->files !!}`);
                        for (let f of json) {
                            let h1 = $('</p>');
                            h1.text(f);
                            let h2 = $(`<input style="" type='hidden' name='uploaded[]' style='margin-top:5px;margin-bottom:5px;' title=''>`).val(f);
                            let hc = $('<div>');
                            console.log(hc);
                            hc.append(h1);
                            hc.append(h2);
                            addFile(hc[0]);
                        }
                        @endif
                        var uploadCount = 5;

                        function addFile(uploadedFile) {
                            if (uploadCount && fileLength >= uploadCount) {
                                alert("파일은 " + uploadCount + "개 까지만 업로드가 가능합니다.");
                                return;
                            }
                            var objTbl;
                            var objRow;
                            var objCell;
                            if (document.getElementById)
                                objTbl = document.getElementById("variableFiles");
                            else
                                objTbl = document.all["variableFiles"];

                            objRow = objTbl.insertRow(objTbl.rows.length);
                            objCell = objRow.insertCell(0);
                            if (uploadedFile) {
                                objCell.append(uploadedFile);
                            } else {
                                objCell.innerHTML = "<input type='file' name='files[]' style='margin-top:5px;margin-bottom:5px;' title=''>";
                            }

                            fileLength++;
                        }

                        if (fileLength < uploadCount) {
                            addFile('');
                        }

                        function deleteFile() {
                            var file_length = 0;
                            var objTbl = document.getElementById("variableFiles");
                            if (objTbl.rows.length > file_length) {
                                objTbl.deleteRow(objTbl.rows.length - 1);
                                fileLength--;
                            }
                        }
                    </script>

                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $("#{{$board->name}}").css({'background-color': '#ed6e0c'});

    class MyUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }

        upload() {
            return this.loader.file
                .then(file => new Promise((resolve, reject) => {
                    this._initRequest();
                    this._initListeners(resolve, reject, file);
                    this._sendRequest(file);
                }));
        }

        abort() {
            if (this.xhr) {
                this.xhr.abort();
            }
        }

        _initRequest() {
            const xhr = this.xhr = new XMLHttpRequest();

            xhr.open('POST', "{{route('upload.image', ['_token' => csrf_token() ])}}", true);
            xhr.responseType = 'json';
        }

        _initListeners(resolve, reject, file) {
            const xhr = this.xhr;
            const loader = this.loader;
            const genericErrorText = `Couldn't upload file: ${file.name}.`;
            xhr.addEventListener('error', () => reject(genericErrorText));
            xhr.addEventListener('abort', () => reject());
            xhr.addEventListener('load', () => {
                const response = xhr.response;
                if (!response || response.error) {
                    return reject(response && response.error ? response.error.message : genericErrorText);
                }
                resolve(response);
            });

            if (xhr.upload) {
                xhr.upload.addEventListener('progress', evt => {
                    if (evt.lengthComputable) {
                        loader.uploadTotal = evt.total;
                        loader.uploaded = evt.loaded;
                    }
                });
            }
        }

        _sendRequest(file) {
            const data = new FormData();
            data.append('upload', file);
            this.xhr.send(data);
        }
    }

    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new MyUploadAdapter(loader);
        };
    }

    ClassicEditor
        .create(document.querySelector('#editor'), {
            extraPlugins: [MyCustomUploadAdapterPlugin],
            language: 'ko'
        }).then(editor => {
        self.editor = editor;
    }).catch(error => {
        console.error(error);
    });
</script>
