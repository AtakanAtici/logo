
const down_payment_rate_input = document.getElementById('down_payment_rate');
const repeater_button = document.getElementById('repeater_button');
const clear_button = document.getElementById('clear_button');
const season_select = document.getElementById('season_select');
const brach_id = document.getElementById('branch_select');
const opponent_select = document.getElementById('opponent_team_select');
// const score_players = document.getElementById('TagifyUserList');
const submit_button = document.getElementById('submit_button');
const score_we = document.getElementById('score_we');
const score_opponent = document.getElementById('score_opponent');
const date = document.getElementById('date');
const time = document.getElementById('time');


function repeatForm() {
    let form = document.getElementById('form');
    let form_clone = form.cloneNode(true);
    form_clone.classList.remove('d-none');
    let form_parent = form.parentNode;

    let form_select = form_clone.getElementsByClassName('stock_id')[0];


    form_parent.appendChild(form_clone);
    
    $('.stock_id').on('change', function(e){
        let vat =  getStock(e.target.value,form_clone);
    });


    $('.quantity').on('input', function(e){
        let without_tax = e.target.value * form_clone.getElementsByClassName('per_price')[0].value;
        let tax = form_clone.getElementsByClassName('tax_percent')[0].value;
        let total = (without_tax * tax / 100) + without_tax;
        form_clone.getElementsByClassName('total_price')[0].value = total;
    });


    $('.select2-container').remove();
    $('.select2').select2();
    $('.money').mask('000.000.000.000.000,00₺', {reverse: true});
    $('.deleteDueDate').on('click', function () {
        //this element is a button we need to get its parent form
        removeForm(this.parentNode.parentNode.parentNode);
        console.log("tried to remove");
    });
    
$('.goals').on('change', function (){
    let goals = document.getElementsByClassName('goals');
    let total = 0;
    Object.keys(goals).map(key =>{
        total += parseInt(goals[key].value);
    });
    if(isNaN(total) || total == undefined || total == null || total == "" || total < 0){
        total = 0;
    }
    document.getElementById('score_we').value = total;
});
}

repeater_button.addEventListener('click', repeatForm);

//ready fonksiyonu içerisinde çalışmıyo

function submitHandler(){

let code = document.getElementById('code').value;
let order_date = document.getElementById('order_date').value;
let status = document.getElementById('status').value;
let current_id = document.getElementById('current_id').value;

let form_data = new FormData();
form_data.append("code", code);
form_data.append("order_date", order_date);
form_data.append("status", status);
form_data.append("current_id", current_id);
form_data.append("items", JSON.stringify(readItems()));
form_data.append('_token', document.querySelector('meta[name="csrf-token"]').content);

$.ajax({
    url: "/orders/store",
    method: "POST",
    processData: false,
    contentType: false,
    data: form_data,
    beforeSend: function (){
        submit_button.classList.add('disabled');
        submit_button.innerHTML = "<i class=\"fa-solid fa-spinner fa-spin\"></i> Gönderiliyor..";
    },
    success:function(response){
        submit_button.classList.remove('disabled');
        submit_button.innerHTML = '<i class="fa fa-save"></i> Kaydet';
        window.location = '/orders/list';
    },
    error: function (response){
        if(response.status == 422){
            let errors = response.responseJSON.errors;
            if(!errors){
                errors = response.message;
            }
            if(errors){
            Object.keys(errors).map(item =>{
                Toastify({
                    text: errors[item][0],
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "linear-gradient(to right, #f44336, #ff9800)",
                    stopOnFocus: true,
                }).showToast();
            });
        }
        }else{
            Toastify({
                text: "Bir hata oluştu..",
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #f44336, #ff9800)",
                stopOnFocus: true,
            }).showToast();
        }
        submit_button.classList.remove('disabled');
        submit_button.innerHTML = '<i class="fa fa-save"></i> Kaydet';
    }

})
}

let data = [];
function readItems(){
let stock_ids = document.getElementsByClassName('stock_id');
let quantity = document.getElementsByClassName('quantity');
let per_price = document.getElementsByClassName('per_price');
let tax_percent = document.getElementsByClassName('tax_percent');
let total_price = document.getElementsByClassName('total_price');

//d-none olan ilk değeri sil
if(data.length == 0){
    stock_ids[0].remove();
    quantity[0].remove();
    per_price[0].remove();
    tax_percent[0].remove();
    total_price[0].remove();
}


data= [];
Object.keys(stock_ids).map(key =>{
    let new_data = {
        'stock_id':stock_ids[key].value,
        'quantity':quantity[key].value,
        'per_price':per_price[key].value,
        'tax_percent':tax_percent[key].value,
        'total_price':total_price[key].value,
    }
    data.push(new_data);
});
return data;
}




function removeItem(e){
e.parentNode.parentNode.remove();
}

function getStock(code,element){
    $.ajax({
        url: "/stock/get/"+code,
        method: "GET",
        success:function(response){
            let vat = response.VAT;
            console.log(vat);
            element.getElementsByClassName('tax_percent')[0].value = vat;
            element.getElementsByClassName('per_price')[0].value = response.price;

        },
    });
}


