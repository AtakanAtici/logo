<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><i class="fa fa-user-plus"></i>&nbsp;Yeni kullanıcı
                    oluştur</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <form method="POST" action="{{route('user.store')}}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Adı & Soyadı</label>
                        <input type="text" class="form-control" id="name" name="name"
                               placeholder="Kullanıcının adını giriniz.." required/>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-posta Adresi</label>
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="Kullanıcının epostasını giriniz.." required/>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Rol</label>
                        <select class="select2" name="role_id">
                            @foreach($roles as $role)
                                <option value="{{$role->name}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Durum</label>
                        <select class="select2" name="status">
                            @foreach(config('status.user_status') as $key => $status)
                                <option value="{{$key}}"
                                    {{$key == 1 ? "selected" : ""}}
                                >{{$status}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="password">Şifre</label>
                        <div class="input-group input-group-merge">
                            <input
                                type="password"
                                id="password"
                                class="form-control"
                                name="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password"
                            />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Vazgeç
                    </button>
                    <button class="btn btn-success">Kaydet</button>
                </div>
            </form>

        </div>
    </div>
</div>
