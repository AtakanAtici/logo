<div class="modal fade" id="removeModal-{{$user->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Rolü sil - {{$user->name}}</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                    <span>Bu kullanıcıyı silerseniz, bu kullanıcının oluşturduğu bütün veriler de silinecektir!</span>
                <br>
                    <b class="text-danger">
                        <i>{{mb_strtoupper($user->name)}}</i> ADLI KULLANICIYI SİLMEK İSTEDİĞİNİZE EMİN MİSİNİZ?
                    </b>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                    Vazgeç
                </button>
                    <a href="{{route('user.destroy', $user->id)}}" type="button" class="btn btn-danger">Evet, Sil</a>
            </div>
        </div>
    </div>
</div>
