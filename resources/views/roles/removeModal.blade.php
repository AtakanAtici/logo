<div class="modal fade" id="removeModal-{{$role->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Rolü sil - {{$role->name}}</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                @if($role->name != "Yönetici")
                    <span>Bu rolü silerseniz, bu role sahip aşağıdaki kullanıcıların rolleri alınacak ve yeni rol verilene kadar hiçbir işlem yapamayacaklar!</span>
                    <table class="table">
                        <thead>
                        <tr>
                            <td>Kullanıcı</td>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($role->users as $user)
                            <tr>
                                <td>
                                    <span class="text-danger">
                                    {{$user->name}}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td>
                                    <span class="text-success">
                                    Bu role sahip hiç kullanıcı yok..
                                    </span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <b class="text-danger">
                        <i>{{mb_strtoupper($role->name)}}</i> ADLI ROLÜ SİLMEK İSTEDİĞİNİZE EMİN MİSİNİZ?
                    </b>
                    @else
                    <b class="text-danger">
                        <i>{{mb_strtoupper($role->name)}}</i> ADLI ROL SİLİNEMEZ!
                    </b>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                    Vazgeç
                </button>
                @if($role->name != "Yönetici")
                    <a href="{{route('role.destroy', $role->id)}}" type="button" class="btn btn-danger">Evet, Sil</a>
                @endif
            </div>
        </div>
    </div>
</div>
