<div class="modal fade" id="editRoleModal-{{$role->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="role-title">{{$role->name}}</h3>
                </div>
                <!-- Add role form -->
                <form class="row g-3" action="{{route('role.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$role->id}}">
                    <div class="col-12 mb-4">
                        <label class="form-label" for="modalRoleName">Rol adı</label>
                        <input
                            type="text"
                            id="modalRoleName"
                            name="name"
                            class="form-control"
                            placeholder="Rol adı giriniz.."
                            tabindex="-1"
                            value="{{$role->name}}"
                        />
                    </div>
                    <div class="col-12">
                        <h4>Rol yetkileri</h4>
                        <!-- Permission table -->
                        <div class="table-responsive">
                            <table class="table table-flush-spacing">
                                <tbody>
                                <tr>
                                    <td class="text-nowrap fw-semibold">
                                        Yetkiler
                                        <i
                                            class="bx bx-info-circle bx-xs"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Kutucukları işaretleyerek role yetki verin.."
                                        ></i>
                                    </td>
                                    <td>
                                        {{-- <div class="form-check">
                                          <input class="form-check-input" type="checkbox" id="selectAll" />
                                          <label class="form-check-label" for="selectAll"> Select All </label>
                                        </div> --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap fw-semibold">Rol Yönetimi</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="form-check me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="roleManagementRead" name="view_roles"
                                                    {{$role->hasPermissionTo('view_roles') ? 'checked' : ''}}
                                                />
                                                <label class="form-check-label" for="roleManagementRead"> Görüntüle </label>
                                            </div>
                                            <div class="form-check me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="roleManagementWrite" name="create_roles"
                                                    {{$role->hasPermissionTo('create_roles') ? 'checked' : ''}}
                                                />
                                                <label class="form-check-label" for="roleManagementWrite"> Oluştur </label>
                                            </div>
                                            <div class="form-check  me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="roleManagementEdit" name="edit_roles"
                                                    {{$role->hasPermissionTo('edit_roles') ? 'checked' : ''}}
                                                />
                                                <label class="form-check-label" for="roleManagementEdit"> Düzenle </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="roleManagementCreate" name="delete_roles"
                                                    {{$role->hasPermissionTo('delete_roles') ? 'checked' : ''}}
                                                />
                                                <label class="form-check-label" for="roleManagementCreate"> Sil </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap fw-semibold">Kullanıcı Yönetimi</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="form-check me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="userManagementRead" name="view_users"
                                                    {{$role->hasPermissionTo('view_users') ? 'checked' : ''}}
                                                />
                                                <label class="form-check-label" for="userManagementRead"> Görüntüle </label>
                                            </div>
                                            <div class="form-check me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="userManagementWrite" name="create_users"
                                                    {{$role->hasPermissionTo('create_users') ? 'checked' : ''}}
                                                />
                                                <label class="form-check-label" for="userManagementWrite"> Oluştur </label>
                                            </div>
                                            <div class="form-check  me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="userManagementEdit" name="edit_users"
                                                    {{$role->hasPermissionTo('edit_users') ? 'checked' : ''}}
                                                />
                                                <label class="form-check-label" for="userManagementEdit"> Düzenle </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="userManagementCreate" name="delete_users"
                                                    {{$role->hasPermissionTo('delete_users') ? 'checked' : ''}}
                                                />
                                                <label class="form-check-label" for="userManagementCreate"> Sil </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap fw-semibold">Cari Yönetimi</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="form-check me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="currentsManagementRead" name="view_currents"
                                                    {{$role->hasPermissionTo('view_currents') ? 'checked' : ''}}
                                                />
                                                <label class="form-check-label" for="currentsManagementRead"> Görüntüle </label>
                                            </div>
                                            <div class="form-check me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="currentsManagementWrite" name="create_currents"
                                                    {{$role->hasPermissionTo('create_currents') ? 'checked' : ''}}
                                                />
                                                <label class="form-check-label" for="currentsManagementWrite"> Oluştur </label>
                                            </div>
                                            <div class="form-check  me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="currentsManagementEdit" name="edit_currents"
                                                    {{$role->hasPermissionTo('edit_currents') ? 'checked' : ''}}
                                                />
                                                <label class="form-check-label" for="currentsManagementEdit"> Düzenle </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="currentsManagementCreate" name="delete_currents"
                                                    {{$role->hasPermissionTo('delete_currents') ? 'checked' : ''}}
                                                />
                                                <label class="form-check-label" for="currentsManagementCreate"> Sil </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            
                                <tr>
                                    <td class="text-nowrap fw-semibold">Sipariş Yönetimi</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="form-check me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="view_order" name="view_order"
                                                {{$role->hasPermissionTo('view_order') ? 'checked' : ''}}
                                                />
                                                <label class="form-check-label" for="view_order"> Görüntüle </label>
                                            </div>
                                            <div class="form-check me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="create_order" name="create_order"
                                                {{$role->hasPermissionTo('create_order') ? 'checked' : ''}}
                                                />
                                                <label class="form-check-label" for="create_order"> Oluştur </label>
                                            </div>
                                            <div class="form-check  me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="edit_order" name="edit_order"
                                                {{$role->hasPermissionTo('edit_order') ? 'checked' : ''}}
                                                />
                                                <label class="form-check-label" for="edit_order"> Düzenle </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="order_price" name="order_price"
                                                {{$role->hasPermissionTo('order_price') ? 'checked' : ''}}
                                                />
                                                <label class="form-check-label" for="order_price"> Fiyat oluştur </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-nowrap fw-semibold">Ayarlar</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="form-check me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="userManagementRead" name="settings"
                                                    {{$role->hasPermissionTo('settings') ? 'checked' : ''}}
                                                />
                                                <label class="form-check-label" for="settings"> Ayarlar </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Permission table -->
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Kaydet</button>
                        <button
                            type="reset"
                            class="btn btn-label-secondary"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            Vazgeç
                        </button>
                    </div>
                </form>
                <!--/ Add role form -->
            </div>
        </div>
    </div>
</div>
