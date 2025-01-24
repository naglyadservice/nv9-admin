<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">

    <title>Cheque</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <meta name="robots" content="noindex, nofollow">

    <style>
      body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px;
        line-height: 1.5;

        padding: 20px 0;
      }

      .wrapper {
        width: 100%;
        max-width: 420px;
        padding: 20px;
        border-radius: 8px;
        background: #f5f5f5;
        margin: 0 auto;
      }

      header {
        text-transform: uppercase;
        text-align: center;

        padding: 20px 0;
      }

      .sale {
        display: grid;
        grid-template-columns: 60% 20% auto;
        gap: 10px;

        padding: 15px 0;
      }

      .result {
        font-size: 16px;
        font-weight: 700;
      }

      footer {
        padding: 20px 0;
        font-size: 12px;
        color: gray;

        display: flex;
        align-items: flex-start;
        justify-content: space-between;
      }

      .divider {
        border-top: 2px dashed gray;
      }

      check-label {
        display: block;
        padding: 10px;
        border: 2px dashed red;

        font-size: 20px;
        font-weight: 700;
        text-align: center;
      }
    </style>
  </head>

  <body>
    <div class="wrapper">
      <check-label>Очікуйте... Чек фіскалізується.</check-label>

      <header>
        {{$user->name}}
        <br>
        {{$device->address}}
        <br>
        ІД 43987039
      </header>

      <div class="divider"></div>

      <main>
        <section class="sale">
          <span>{{$device->service??'Послуга'}}</span>
          <span>1 x {{$fisk->sales_cashe / 100}} </span>
          <span>{{$fisk->sales_cashe / 100}}</span>
        </section>

        <div class="divider"></div>

        <section class="sale">
          <span>@if($fisk->cash === 0)
                  еквайрінг
              @elseif($fisk->cash === 1)
                  готівка
              @elseif($fisk->cash === 2)
                  картка
              @endif
          </span>
          <span>{{$fisk->sales_cashe / 100}}</span>
          <span>ГРН</span>
        </section>

        <section class="sale result">
          <span>Сума</span>
          <span>{{$fisk->sales_cashe / 100}}</span>
          <span>ГРН</span>
        </section>
      </main>

      <div class="divider"></div>

      <footer>
        <footer-left>
          Чек № TEST-rLQ9cd
          <br>
          16.05.2024 об 17:50:46
          <br>
          ОНЛАЙН
          <br>
          <br>
          ФН ПРРО TEST504656
          <br>
          ТЕСТОВИЙ ЧЕК
          <br>
          <a href="https://checkbox.ua">
            <img
              width="100px"
              src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAPMAAAA8CAYAAACzSIxeAAAABHNCSVQICAgIfAhkiAAAG9JJREFUeJztnXlAE9fWwGeSkIUkkLDvEHZZZUcUBcENccN936rQWl/b1719X1v7nu2rpa1Su4rWFQVcUFFEQREUVyCA7PsmkAABQgJZ5/vD4hfj3CFh0dZvfv9lzr1zbiZzt3PPOYEgHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHJwXAvzSFMMwvPureCVI/sXnHzOkUqnoRbbpVWXra3FZDg5OEWiyE8cPx5SVlZ6bKN0cjsOMbdvfyEGTtbW1Fvy0/wf/idL9/w3Cy24ADg7O+IB3ZhycVwS8M+PgvCLgnRkH5xUB78w4OK8IeGfGwXlFwDszDs4rAt6ZcXBeEfDOjIPzioB3ZhycVwS8M+PgvCKQRlOJyWSa6emzrGhUGksul0tEogG+SCTii8Wi7vFu4PO69cwZDKYpnU43ksqk4oEBYaegp6cBQRCgn/dYIJFIFDqdbsxk6plTqTR9qVQqEokG+L29gmaFQiGdCJ3D0HR1DVj6LGtdXboRgigVIpGoSyQS8UWiAf5Efd+/Crq6dEMmk2nG1NOzkMvkQ/3Cvse9AkGTUqmUT4Q+EolEpdMZxgwGw4RG02XL5bKhAZGIPyAUdg4NDfZOhM7xRqPOTCKRKO4eXks9Pb2X29lxQnV16YZo5UQiUVdDQ10Ot6jgREVF2YXxeuEMDY0c/QOCXvPymryCzTbgqMsHBoSdFRXlF2/fuvk9j9dZMVZ9DAbT1M8vYJObu+cSS0srPwKB8Nxzkslkg42N9XnVVZUZDx/ePySRDPWPVS8Mw7CTk8scb2+f1fYOTjP19fWt0MpJpZKBpqbG/NKS4pTi4sIkmUw2OFbdmmBlZR0we3bUbjbbwA4mwER1eXb21V1FhQ+Pjvb+enr6llNCpu309PRebmBgaK8uHxSLe0pLi1Pv3r39c0dHe8lo9QzDZhtwPDy9lzk7u861s+NMIxKJZLRyfX29LXV1NddLirmnamqqMhEEQbDuGxAQvG1G2MyP0O/V15p/O3evtsEt4eGRn/r4+K0nEIk66rKystKzGZcvvj9i1JTrJPcF0dGL9qI9XCx4vM7y7KzML0pLi1PR5JpETUEQBIXPnPU/U6dOf5tEIlFG0qlQKGS3b+f+kHnl0sejGUjIZDI9NDTsvdDp4e+TyWS6pvUGxeKevLyc+Ly8nHiFQiHTVi8EQZC1jW3w/KiF39nY2oVoU6+/v6/tevbVLx8+vH9QqVQq0MqMR9QUh2M/fdPmbRk6OmRdNDmXW3giNSVpvfqLrknUFIFAIIWEhP4jctacXWQyhTFSWxQKhSwvN+fb7OzMXaNZHenrs6xDp4e9Fxg4JVaT90qVjo720hvXr/0b9F5DEAQRiUSd1994656FhaUPmlwul0t+TPhuMp/Pq9RE5+TJvmtXrFx7HE0mFPa3J+yL9xKJRF3Pja7DMJl65hs3vXYpLGzmRzSaLlsTparQ6QxjT0/v5Wy2gV11deUV9RcNhmE4ImL256D6xcVFSZs2b7vs4eG1FG1mRINAIBBtbTlTjY2MXcrLH6WNNIKqYmFh5Rsbt/P2JDf3haARGoSOjg7NwdEpws7OPrSqquKyTCYVa16XrLt06YrEBQuX/KjPYllroxeCIIhCoeq5TnJfwLF3DKuqLE+XyWTP6fb19d8AGoxLS7jJI71ULBbbZsvWuGs0Go2FJm9rbXl44viRpWgDGZttYOfnF7AJrZ5Q2N9eWlKcsmnztsuBgVO2E4kkjZ47gUAg2nHsQ01NzTzKHpWc0Wbg9vb2Wb1la9w1OzvONE3fK1UYDKapp6f3cnMLy8nV1VWZcrl8SL0MgiDKxsb6PP+AoK1oOggEAsnMzMKrqPDhkZH06erSDddv2HoBbXJBEAQ5der46vb2x8UQBDCAsdkGnNff+MddDsd+umZfEYyvX8CmLVvjsjQZcVXZHvtmnpmZuddodHp5+6wKDQ17T9Pyzi6u87bHvnETtKzVFHt7h7DYuDdvUanoL706FAqFuXVr7DUfX/8NY9ELQU9mztffeOse2jZkLOjo6NDWrt14hsFgmKDJe3sFTUeOHIzWZgAbhkajsbfH7rjJ4TjMGE3b3N09lyxesuxXTcrCMAzPnh21e8XKtSd0dHRoo9Gnipubx+LtsTtyGQymKZqcx+ssz87O3AWqz+HYT/f1RR/kVIlesHgf6Nnfu5f/S1VlxaXhz891ZhKJRF2/YUsai8W2GUmRpkglEqFMpl2iARqNpvVqQJWIyDm7WCy27UjlLCysfNet23wOa7BRKpVyHq+zvLGx4VZHR3spVtIEIyNj55Ur1x6HYXjEk4KYmBWJ2i6rsUAQRCkWi7rG634wDMMxS1cetLSyRk0gIJVKBo4dPbRoYEDYOZr7GxgY2o92wB7G3z9oq7Oz69yRys2cOeuzsPCIT2AYHreEHGZm5p4bN25NB209cm/e2NPY2HALVD8qakE8qKNCEAQ5O7vOnTzZdy2arKe7u+5KxqUPVa89twSIjl68F+sBK5VKeXFx0cnS0uLU7i5+jUgk4tNoNLapqZmH92TfNe7unktUlxb9/X1tqalJG7RZ8qrD43VWcIsKjrV3PC4ZEAo7qFQay97eISw4eOobNF1dA7Q6JBKJEhQc8nrmlUuohggIgiAqlaq/Zs2GFNC+qb+/ry07K/OLkhJuskQiEarcm+rm5rFoztz5X6PNhC6uk+b7+PivLyx8AFxGBQWFxHl6TV6B9b2rqyozuMWFSe2P27gi0QCPRNKhGRkbO7u7eS7x8fXfoLr0ksvlQ0knji5XbedYmT49/ANvb5/VaDIEQZQpyUnrhpd440FLc9PdIm7B8Z6e7nrRwACPzmCYODo4RQQEBm+jUKh6oHrR0Yv27t1b7Q6yGdjbO4bPjJj9GZbuurqa7GJu0cm2ttYCsVjUTaFQGCwW29Z1ktsCP7+ATaAOa2ll7T9vXvSeCxfOvqkuQxBEefZsyms7d/6zCG01QNPVNZgXtTA+NSXpuZWZjg5Zd+GimJ/QdCqVSnly8vG1UqlkQPX6M53Z1pYzNTBoSizoC3d3d9UmnTi6vL29jat6XSwWdXd3d9WWlz9KMzAwtI+av/A7NzePxVKpVJSUdHSFSDS62WJgQNh5+dKFd7ncwhPqsrq6muz79+/8tm3bjhwDQ0MHtPo+Pv7rsTpzRMScz0F129sfF/9x6Pc5aLOOXC4fKinhJtfUVl/bujX2moWFla96mfDwyE+53IITaEcpdDrDOGr+gu9A7RoaGupLPnV8TVVVxWV1WW+voKm2pvra1WsZ/4qMnLMrKCgkDoZhYlra6dfVf5ex4OjkPGvW7Hm7QfIrVy59VF7+6Px46BIK+9tTU05uqK2tzlKXVVdVZuTn30rYsjX2mpGRsTNafSNjExcHR6fImuqqTHUZDMPw/OhFP4BWSnK5fCg1JWkDmkGLx+usqK6uvJKXmxO/bv2ms+bmlpPR7hEUHPL6nTu39qPZHrr4vKqrmZc/mR+96Ae0uj4+fuuLih4eq62pvqZ6fc6cqK9Ado4bN7J2t7Q031O//swXnBY64120yhD0pGMdTPw1cqQXpqenu/74sT+WfLtnt/3XX+2yaG5qzMcqD+Lx49bCHxO+90HryMP09fW1nj2bsg0k19PTswA9EDqdbhQQGLwdTSaRSITHjh5aONLycVAs7jmZdGwlmhHE0MjIadIk9wVo9YKCQ14HjfQKhUJ29EhiNFpHVtd98cK5nd/890vrr7/aZV5Y8OAwVnltMDQyclqzZkMKgUBANZAWFj44kpd749vx0NXF51Xt//F7X7SOPExvr6D5yJHEaCzLta9vwEa06y6ubtHm5hbeoHqpqSc3YlmmIQiCBIKehj8OHZjb39/XhiaHYZgAOoqCIAjKz89LqK+vywHJFy1a+rPqzG1lbRMYPGXqczM9BD05Aci5kYU6yD7tzGy2AWfSJPeFIIUZGekf9PYKmkBydQSCnoaxnL0ePPjbLKGwv32kcvX1tTe6u7pqQHJLSys/tOuBQSFxoOOnW7duft/bK2jWpJ3d3V21oJfByclljvo1IpFIDg4OeQN0vzt3bv2Itc9SRygUdox2z4oGhUJhrlu3+RzIiNfY2HAr7dxp4OpNG0QiUdehQ7/PFgqFHSOV7e7qqnnw4G4iSD5pkvtCtMEHyxBaXVWZUVrCTdGkrQMDws6rmRmfguTe3r5rmEw9czQZgiDKM6dPbVFfFg9jaGjkGBYe+SkEPXk/YmJWJKJ9F5lMKk5OPrEWdPz5tDO7TnKLBo3Evb2CZm5RwTHQF5kIZFLNraOtrc0PQDI6nWGMdn2SqxvqrIkgiPLhg3sHNdUNQRAEmkUdHZ0j1a/Z2NgGgyygSqVSkXvzxh5tdI8nMAzDS5etOmRqauaOJhcIehqTThxeKpfLJeOhr7dX0KTpoAlBEFTMLUoCychkMt3Y2MRV9RqVStW3tbWbCqpz69bN7zXVDUEQxOUWnBCJBvhoMiKRqOPo6PTc7z2MQNDTcPnyReDAMn16+PumpmbuQUEhcWZm5p5oZTIy0j/o4vOqQPd42pk5HAfgMdSjRyWnx2LAmmhEIhHqA4YgdKs4jUZjWwBmbB6vs6Kvr7dFG/18Hvo5rYGhoQOJRKKqXrPDeM4NDXU54znLagMMw4T50Yv2enh4LUOTSyRD/UcOJ84fGBjgvei2DdPc3HgH6yRB/Te1t3cMA01Qg4ODgvr62hxt9CuVSjnW9sfBEd0xZ5gH9+/+jravh6AnM/LiJct+C5ka+haavKa6KvPe3fyfse7/1ABma8uZBirU3NR4B+smLxuFQg7cS6G5v1lZ2QSAfmQymUxfvGT5b9rop1IoQEsrnU436uvrax3+bPcXe86hoWHv+fj6bzAzNfcEGQMVCoX0+LHDMTxeZ/mLbp8qCIIou7r41SDPKnUDmZ0dJxR0r/b2Nu5o/LzbWlsfgvbntrYc4CoAgp44eZw5c2rLW29/8AhtkgHVHxwcFJw9m/zaSBMqCYKeLBEYDAbq0g+CIKizs+MR1k3+bmB9VzbbwC4QYBgbDXQ6w1i1M+thOKa8jOc80jm3SCTqSj51fHVdXU32i2oTFr29gmZQZ6ap7fMZTD0z0H1G68OP5S0H2jOr0t/f//hS+vl3li1fdVhTnWlpp+NU3yEQBAiCIBpN1wDrMH08HRH+CoD20RPDs8+VTqcbgUqO9ghvIkEQRPlXapdUKkU1IkHQkz2y6mc6nQ78nQfF4p7R6B8cFAtAMjKZTAedUqhSWPjgSFlZ6VlN9BUVPjyqqZHuz86M7W0lkaBb4f6uaOtcP1oQBEHUjzOwXD1B1s6XCYPBMNm8ZXumJrPOiwArQoxMedaLT5eG7lD05320dj+FoCfHllhyXV1d1IhCdQoLwA5Fz+jT4p0gQRD2A4IgCCISSWS0s9S/K1hx13w+r7Kjo710zEoQBKlHMWjJ5fIh0GCiaaDBi4bBYJgsXbby0JHDiVEv2xCK5VctGXr2KFQmB7/XowmygKAnW1IsuSaDhI6ODi0qamG8JvqCgkLiSku4yQ0N9bkjlSVBEAQNDmIvOahUqv54xOv+VRCLxcDO3NhYn3fubOq47Zmf1y3qVl8ODgO6PpEcO3poUUVF2QU9PX1LP//AzbNmzf03WjlnZ9e5gYFTYu/dy9cosGGiwDI2Dg4OPrMExvqddbQIcVWFTKEwQTKlUqnAWoYPM2v2vP8YGhk5aaIPhmFCTMzKxISEeO+RJl0CBD1ZOmCdHRoYjG8kzssGaw+obdy2tmC9YOyX+Jz7+/vably/9p+SEm4yqMy8qAXxhoZGji+yXeqw2AZ2IJn6igvrd9bXZ40qQo6lDw5THRwU94wUjmljaxcSEoJ+/ATC0MjIKTJyDjACa5in58xY3l3mAOvh3xUer6MMJLOysgkcaSk1FrCeM8hK+yK5cP7sDpBHFplMpi9fsfoo6FhvoiESiWRjYxMXkPzx47Yi1c89PV11oLIgx4yRMAE41EAQtqUbgp4sr5ctXXkI7fkplUrFtasZ/wLVnTptxjtWVtYBWPd/2plbW1uAXlQuLpOisG7yd0MkEnV1dfGr0WQUCoWJdT45Vlpamu+DZM7OrnNfVkcZRiwWdaedSwW6a9rY2E0JnR72/ots0zAce4cZoMQRCIIgLS1Nd1WvtTQ/+1kVExNTdyaTCTy6AuHg4DgTJKurq72OVTcycs4uI8BgxOUWHM/Jyf4KFMtAIBBIMUtXHsRKnPG0M2N6tjg4RYxnfPNfgQqMiJ+pU6e/PVF6qzGeM5OpZ+7k7DJibO5EU1FRdqGYWwh0nYyMnLsLK3hhogCFY0IQBPH5vAr1ZXVTU+Nt0BEUgUAgenn5rNJGP4vFtsVyDKmrBZ/FW1vbBE2dNuOfaDKxWNR9JSP9AwRBkHPnUmNBvtdmZuaeYWERH4N0PO3MlRVlF9UNCE8LEQjEeVELNLK+DaOjo0MDxRr/Fbh//+7vIA8gF1e3aKygExAwDMN6evqWWLNrZ2dHWVtry0OQfN68BXu0Web/6fADDHAfLefPn90BihIiEonklavWJam7qmoLASUpIAhjYxPXyZP91oHkaEc9CoVCVlBw/w9QnRlhER9rY3SMnDVnFyiUsqenu765Gd2Dj0QiUWKWrjwIei/SL6a9Newm29nZ8ejundv7QW0IC4/8xNTUzANN9rRhEolEeOfOLeBNPD29l08LDQOGSKri6xuw8eNPPn/8r3992RUcPBUYIfQy6e7uqgXNPjAMw8tXrDlqb+8Qpsm9YBiGPTy8lr719vuPPvr4s9Ydb75TgHWefPPm9f+CZCYmpm4xMSsSNclUwuE4zPjnux9Vf/Lprs7FizVLn6MpQ0ODvWnnTsdhtTMiYg4wh5smmJtbTtbknaJQqHorV609ARrk5HL5UEHB/UNosry8nHiQFZjBYJisXrMhRZOcbz6+/ht8fPzXg+Q3c7K/Bk0OkbPmfgkKXqmuqsxQD/PNyrryOdZAuhQwMDzzwtzJz0vAOhSfNy/62yUxKw6AvJjMzMy9NmzYcmHZ8lWHqVQaC4ZhOHrB4n1Y+4yXyY0bWbtBMbJUKlV/y9a4a/PnL/peT0/PAq0MmUymBwQEb3tz5zuFa9ZuPG1iYuoGQRBkbm7hvWrVuiRQhywrKz2H5efs4+u/YdPmbRmg4wt9fX2rxYuX/br1tbhs9p/W3cCgKbFTQqbtHOEra0VlZXl6EUa03PQZ4R+MNU9cVNSC+GXLVx0G7V+trKwDtsfuyEVLADHM/ft3fgdZroVCYceDB3cPgOo6ObnM3r59x00ra5tANDmdTjeKXrB437Jlq/7AmpULASmGra1tgqZNQ88TIJVKRefPn9mhfl0ikQgvpZ9/B9RmK2ubwBCUreBzLpw+Pn7rl69Yg5n7WKFQyBoa6m7y+bxKqVQqolFpLAsLSx9LK2t/tC8sEg3wf9q/11813G2kVLuf/c+HNE0dVebNi94TOj0c1SiTnX11V3ZW5hegujNmzPxwztz5wJkSgp4YVzo7O0r5fF7V4OCggEwm01kstq2lpZUflhNDTk7211czL3+CJrO0svaPi9t5G2tWQBAEaW1tud/+uI07ODTYSyaT6SYmZm62tnZT0RxPFAqF7GDirxGNjfV5qtexUu0OnzOD2kClUvXfevuDR6BkhwJBT0PCvnhv0CSAlWpXFaVSqWhubszvaG8vGRoa6qPp0gxsbGyDQdk9huntFTTt/eFbDyzvOQqFwty5890iUCDJMD093fXt7Y+5AwNCHplMoRsYGNhbW9sGY22b5HK55Pff9oeiGZBJJBJlx5vvFIBm5QsXzr55985t1NRAEARBGze9dglkfJbJZIMJCfHeqrH8z3nBFBUVHLN3cAz38wvcDFLyJHbTORItXhcdGCaTyVpl53xR5Obe2GNqZu4JSpwGQU8GHjMzcy9tk8+RMfx021pbHl7JSP8QlE5mWK+1tU2QtbVNkIYqEQoV7FQxGoaGhvrS0lLjNm58LR1NzmYbcObOi95zPu3M62PRQyAQiHZ29qF2dvYanyTI5XLJ6dRTm0dyg5VIJMKjRw8uiI198xaWHcfAwNBeWz+DS+nn3wadBEVEzPkC1JFbmpvu3rub/wvWvdMvpr3l4OA0E802oaOjQ4uJWXEg8cAv4cNeeajLhrRzp2PH8s8EqvT2CpoOJv4S8bLD50AgCIKcTj25UdtA9RHuqbyeffXLS5fASyUIgqDbt3P3Xs28/Ml4uEhKJEP9x4//EaOaenW8qKqsuISVligwcErsaI4v8/PzEkbrWahQKKRJSUeX19fX3tCkPI/XWXHgwM9hoL2otvw5kGwCecRZWFj6gNJwyeVyyZkzyVtHcjDp7u6qvXnz+jcgOYfjMCMw8P9y9qF2ZoVCITt9+tSmrKzMz8fyf0olJdzkn/b/4D8efyUykSiVSsXlSxfeTU09uXGs/5fF43VWHDr42+ysrMzPNemkOTnZX6ekJK0by/8ZNTY23Pr5p31BE9GRh0lPT3sblLThSUreFYmgvy0CUVRUcOzI4cT52j7z3l5B8+E/DkRVVpRd1KZeR0d76Y8J3/uUlHCTx5gttvxg4q8RoOyrRCKRvGz56iMgg92N69f+renkdjMn+2us7CJz583/ZvjYGGgxRRAEuZ599csffvjG7dGjktOgNKbqKJVKRUVF2YXff9sfeurksVV/pfC5kSgqfHj02z27OVnXrnymTbsRBEGamxrzU1KS1ifsi/fSNva3mFuYFP/t1475+XkJ2gS0NDc15iedOLLswO8/Tdf0r05Gy9DQUF9KctJ6kGWYydQzX7hwCfA0RB2hsL+9o/1xSWNjw62EffFelZXl6SN1MJlMKr59O3fvvr3feow2vlokGuCfOnls1f4fv/cpL3+Ups3fCfH5vMrU1JMbE/bFezU1NdwGlZsZMfszkIdZXV3t9dxczVNDyeVySWrqyY2g506hUPUWLV76CwShGMBA0Ol0IxcXt/kODo4z9VksawaDaUaAYYJYLO4Wi0XdPYKehpaW5ns11VWZmo60M2bM/BAky8vL+U7TTBD29o7h1gBrZFNTw21tEuQNQyAQiJaWVv5OTi6zTU3NPBhMPTM6nW6MIIhycFDcIxaLe3oFgsa2tpaC2tqaLE2SD2oCmUymOzm5zHZydp3LZrFt9fT1LUkkEnX4Off397W1trQ8qKmpuqppgkUvb59VbMAfAjx6VHKmu7urVtP2sVhsG0dH51mgE40HD+4lqv7+TKae+aRJz+ZbUyiV8vq62usCQU+j6nVDIyOnyZP91pqYmLrp6+lbkikUxtDQYB+fz69qbKjLrawsTwf5QowWCoXCdHBwinBwcJqpz2LZMOgMY1063Ugmk4qFQmGHSCTit7Q03auurrzS090NdA8dhkgk6kwJCf0HESUqSygUdpSWFqeO5t8/jI1NXB2dnGeB7DAF45idFQcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHBwcHB+dF878KdVQUT7HzxwAAAABJRU5ErkJggg=="
              alt="Logo">
          </a>
        </footer-left>

        <footer-right>
          <img
            width="145px"
            alt="QR Code"
            src="data:image/png;base64,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">
        </footer-right>
      </footer>

      <check-label>Очікуйте... Чек фіскалізується.</check-label>
    </div>

    <script src=""></script>
  </body>

</html>
