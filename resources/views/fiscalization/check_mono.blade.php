<!DOCTYPE html>
<html lang="uk">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">

    <title>Перевірка чеку MONO</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">

    <meta name="robots" content="noindex, nofollow">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <style>
      * {
        padding: 0;
        margin: 0;
        border: 0;
        box-sizing: border-box;

        font-family: "Montserrat", sans-serif;
        font-size: 16px;
        line-height: normal;
        color: #1A1A1A;
      }

      html,
      body {
        width: 100%;
        height: 100%;
      }

      a,
      a:visited,
      a:hover {
        text-decoration: none;
      }

      *:focus,
      *:active {
        outline: none;
      }

      input::placeholder {
        color: rgba(0, 0, 0, 0.7);
      }

      main {
        display: flex;
        flex-direction: column;

        max-width: 600px;
        height: 100%;
        margin: 0 auto;
        padding: 40px 20px;
      }

      .round-image {
        display: block;
        width: 100px;
        height: 100px;
        margin: 40px auto;

        object-fit: cover;
        object-position: center;
        border-radius: 60px;
      }

      .title {
        font-size: 20px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 40px;
      }

      .sum {
        text-align: center;
        margin-bottom: 20px;
      }

      .payment-form {
        flex-grow: 2;
        display: flex;
        flex-direction: column;
      }

      .input-block {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
      }

      .input-block::after {
        content: "₴";
        font-size: 30px;
        font-weight: 700;
      }

      .main-input {
        display: block;
        max-width: 90px;
        width: 100%;
        font-size: 40px;
        font-weight: 700;
        text-align: center;
        color: black;
      }

      .input-buttons {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-bottom: 40px;
      }

      .input-buttons button {
        display: block;
        padding: 4px 12px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        background-color: unset;
      }

      .input-buttons button:hover {
        background-color: rgba(0, 0, 0, 0.1);
      }

      .buttons {
        margin-top: auto;
      }

      .buttons button {
        display: block;
        width: 100%;
        padding: 12px 20px;
        border-radius: 12px;
        background-color: rgb(83, 83, 231);

        color: white;
        font-size: 16px;

        cursor: pointer;
      }

      .buttons button:hover {
        opacity: 0.6;
      }

      .promo {
        display: block;
        margin-top: 20px;
        margin-bottom: -10px;

        text-align: center;
        font-size: 14px;
        color: gray;
      }

      .promo:hover {
        opacity: 0.6;
      }

      .cntrlmsg {
        text-align: center;
      }
    </style>
  </head>

  <body style="background-color: white">
    <main>
      <img class="round-image" src="{{ asset('img/pride_logo_mono.png') }}" alt="">

      <h1 class="title">{{$device->place_name}}</h1>

      <form class="payment-form" id="paymentForm" method="POST" action="{{route('go_payment', $device->device_hash)}}">
        @csrf
        <div class="payment">
          @if($device->enable_payment)
          <p class="sum">Сума платежу</p>

          <input type="hidden" name="system" value="{{$device->payment_system->system}}">

          <div class="input-block">
            <input class="main-input" type="tel" size="1" maxlength="3" placeholder="0" name="amount" id="amount_field">
          </div>

          <div class="input-buttons">
            <button type="button" data-increment="20">+20 ₴</button>
            <button type="button" data-increment="50">+50 ₴</button>
            <button type="button" data-increment="100">+100 ₴</button>
          </div>
          @endif
        </div>

       <div class="buttons">
          @if($device->enable_payment)
          <button type="button" id="goPayment">Продовжити&nbsp;&nbsp;&nbsp;→</button>
          @endif
        </div>
      </form>
    </main>

    

    <script>
      try {
        const incrementButtons = document.querySelectorAll(".input-buttons button");
        const input = document.querySelector("#amount_field");

        incrementButtons.forEach(item => {
          const incrementValue = Number.parseInt(item.dataset?.increment);

          item.onclick = () => {
            const value = Number.parseInt(input.value);
            const result = (value || 0) + incrementValue;
            input.value = String(result).slice(0, 3);
          }
        })

        input.oninput = () => {
          const { value } = input;
          input.value = value.slice(0, 3);
        }
      } catch (err) {
        console.log("Errors with input buttons", err)
      }
    </script>

    <script>
      var divideBy = @json($device -> divide_by);

      $(document).ready(function () {

        $("#goPayment").click(function () {

          var amount_field = $("#amount_field");
          let sum = $(amount_field).val();
          let divideBy = window.divideBy; // Use the value from PHP

          if (sum === "" || parseFloat(sum) === 0) {
            alert('Сума не може бути порожньою або дорівнює нулю');
            return;
          }

          if (sum % divideBy !== 0) {
            alert('Сума не кратна ' + divideBy);
            return;
          }

          let controller = '{{$hash}}';
          let button = $(this);
          let form = $("#paymentForm");

          $(this).after('<p class="cntrlmsg">Очікування відповіді від контроллера...');
          $(this).remove();

          $.get(`/check/${controller}/reserve_payment`);

          var checkPaymentInrerval = setInterval(function () {
            $.get(`/check/${controller}/check_allow_payment`, function (resp) {
              if (resp.success) {
                if (resp.msg == "OK") {
                  $(form).submit();
                }
                if (resp.msg == "BUSY") {
                  $('p.cntrlmsg').text('Контроллер відхилив запит на оплату.');
                  $('p.cntrlmsg').css('color', 'red');
                }
                clearInterval(checkPaymentInrerval);
              }
            });
          }, 1000);

        });

      });

      window.addEventListener('pageshow', checkPageShow);

      function checkPageShow(event) {
        if (event.persisted || window.performance && window.performance.navigation.type === 2) {

          window.location.reload();
        }
      }
    </script>
  </body>

</html>