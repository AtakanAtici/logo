<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="role-title">Yeni rol ekle</h3>
                    <p>Rol yetkilerini ayarlayın</p>
                </div>
                <!-- Add role form -->
                <form id="addRoleForm" class="row g-3" method="POST" action="{{route('role.store')}}">
                    @csrf
                    <div class="col-12 mb-4">
                        <label class="form-label" for="modalRoleName">Rol adı</label>
                        <input
                            type="text"
                            id="modalRoleName"
                            name="name"
                            class="form-control"
                            placeholder="Rol adı girin.."
                            tabindex="-1"
                        />
                    </div>
                    <div class="col-12">
                        <h4>Rolün yetkileri</h4>
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
                                        <!-- emopty for select all -->
                                    </td>
                                <tr>
                                    <td class="text-nowrap fw-semibold">Role Yönetimi</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="form-check me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="userManagementRead" name="view_roles"/>
                                                <label class="form-check-label" for="userManagementRead"> Görüntüle </label>
                                            </div>
                                            <div class="form-check me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="userManagementWrite" name="create_roles"/>
                                                <label class="form-check-label" for="userManagementWrite"> Oluştur </label>
                                            </div>
                                            <div class="form-check  me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="userManagementEdit" name="edit_roles"/>
                                                <label class="form-check-label" for="userManagementEdit"> Düzenle </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="userManagementCreate" name="delete_roles"/>
                                                <label class="form-check-label" for="userManagementCreate"> Sil </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap fw-semibold">Kullanıcı</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="form-check me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="roleManagementRead" name="view_users"/>
                                                <label class="form-check-label" for="roleManagementRead"> Görüntüle </label>
                                            </div>
                                            <div class="form-check me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="roleManagementWrite" name="create_users"/>
                                                <label class="form-check-label" for="roleManagementWrite"> Oluştur </label>
                                            </div>
                                            <div class="form-check  me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="roleManagementEdit" name="edit_users"/>
                                                <label class="form-check-label" for="roleManagementEdit"> Düzenle </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="roleManagementCreate" name="delete_users"/>
                                                <label class="form-check-label" for="roleManagementCreate"> Sil </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap fw-semibold">Cari Yönetimi</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="form-check me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="currentsManagementRead" name="view_currents"/>
                                                <label class="form-check-label" for="currentsManagementRead"> Görüntüle </label>
                                            </div>
                                            <div class="form-check me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="currentsManagementWrite" name="create_currents"/>
                                                <label class="form-check-label" for="currentsManagementWrite"> Oluştur </label>
                                            </div>
                                            <div class="form-check  me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="currentsManagementEdit" name="edit_currents"/>
                                                <label class="form-check-label" for="currentsManagementEdit"> Düzenle </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="currentsManagementCreate" name="delete_currents"/>
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
                                                <input class="form-check-input" type="checkbox" id="view_order" name="view_order"/>
                                                <label class="form-check-label" for="view_order"> Görüntüle </label>
                                            </div>
                                            <div class="form-check me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="create_order" name="create_order"/>
                                                <label class="form-check-label" for="create_order"> Oluştur </label>
                                            </div>
                                            <div class="form-check  me-3 me-lg-3">
                                                <input class="form-check-input" type="checkbox" id="edit_order" name="edit_order"/>
                                                <label class="form-check-label" for="edit_order"> Düzenle </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="order_price" name="order_price"/>
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
                                                <input class="form-check-input" type="checkbox" id="userManagementRead" name="settings"/>
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
