<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">

    <title>Перевірка чеку</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{\App\Helpers\Helper::versioned_asset('/dist/css/fiscalization.css')}}">

    <meta name="robots" content="noindex, nofollow">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
<div class="wrapper">
    <div class="container">
        <header>
            <a href="https://www.npc.com.ua/">
                <svg xmlns="http://www.w3.org/2000/svg" width="110" height="32" viewBox="0 0 110 32" fill="none">
                    <path d="M8.96073 8.22697H4.32308V21.1119H8.96073V8.22697Z" fill="url(#paint0_linear_244_4267)" />
                    <path d="M34.4452 21.1118H24.72L13.8052 5.04986H0V0.412417H16.2615L27.1763 16.4744H29.8076V0.412417H34.4452V21.1118Z" fill="url(#paint1_linear_244_4267)" />
                    <path d="M50.3062 20.6767H45.6715V11.1497H68.1726C68.7042 11.1489 69.2138 10.9374 69.5897 10.5615C69.9656 10.1856 70.1771 9.67598 70.1779 9.14439V7.49706C70.1774 6.96529 69.966 6.45545 69.59 6.07934C69.2141 5.70323 68.7043 5.49158 68.1726 5.49079H39.7494V0.853345H68.1696C69.931 0.855439 71.6196 1.5561 72.8649 2.80162C74.1103 4.04713 74.8108 5.73577 74.8126 7.49706V9.14439C74.8108 10.9056 74.1103 12.5941 72.8649 13.8395C71.6195 15.0848 69.9309 15.7853 68.1696 15.7871H50.3062V20.6767Z" fill="url(#paint2_linear_244_4267)" />
                    <path d="M86.2463 16.8859H109.21V21.5233H86.2463C84.6203 21.5233 83.0609 20.8774 81.9111 19.7277C80.7614 18.578 80.1154 17.0187 80.1154 15.3928V8.72042C81.6195 8.71449 83.1858 8.7046 84.7531 8.69471V15.3958C84.7539 15.7912 84.9116 16.1703 85.1915 16.4496C85.4714 16.729 85.8508 16.8859 86.2463 16.8859Z" fill="url(#paint3_linear_244_4267)" />
                    <path d="M109.826 0.00128174V4.63972H80.3002C80.6339 3.31545 81.3997 2.14029 82.4765 1.30018C83.5532 0.460074 84.8793 0.00299758 86.2451 0.00128174H109.826Z" fill="url(#paint4_linear_244_4267)" />
                    <path d="M4.64878 27.4331V31.9222H3.79541L1.55767 29.1961V31.9222H0.53125V27.4331H1.39055L3.62236 30.1582V27.4331H4.64878Z" fill="#35393E" />
                    <path d="M9.31306 30.9621H7.22859L6.83305 31.9242H5.7661L7.76751 27.4331H8.78898L10.7963 31.9222H9.7086L9.31306 30.9621ZM8.98576 30.1711L8.27379 28.4526L7.56183 30.1711H8.98576Z" fill="#35393E" />
                    <path d="M14.8791 29.6063H15.8283V31.4276C15.5733 31.6175 15.2868 31.7607 14.9819 31.8508C14.6684 31.9484 14.3421 31.998 14.0138 31.9982C13.5764 32.0055 13.1441 31.9035 12.756 31.7015C12.3936 31.5116 12.0907 31.2252 11.8809 30.8739C11.6729 30.5096 11.5634 30.0974 11.5634 29.678C11.5634 29.2585 11.6729 28.8463 11.8809 28.482C12.092 28.1293 12.3975 27.8427 12.7629 27.6544C13.1551 27.4521 13.5914 27.3502 14.0326 27.3578C14.3991 27.3524 14.7631 27.4196 15.1035 27.5555C15.415 27.6808 15.6921 27.8788 15.9114 28.133L15.2449 28.748C15.0982 28.5864 14.9189 28.4577 14.7188 28.3704C14.5186 28.2831 14.3023 28.2393 14.084 28.2417C13.8186 28.2364 13.5561 28.2979 13.3206 28.4207C13.1025 28.5364 12.9222 28.7125 12.8015 28.928C12.6794 29.158 12.6156 29.4145 12.6156 29.675C12.6156 29.9355 12.6794 30.1919 12.8015 30.422C12.9223 30.6369 13.1012 30.8134 13.3177 30.9313C13.5489 31.0562 13.8084 31.1192 14.0712 31.1142C14.3523 31.1188 14.63 31.0528 14.8791 30.9224V29.6063Z" fill="#35393E" />
                    <path d="M17.4328 27.4331H18.4711V31.0748H20.7226V31.9222H17.4328V27.4331Z" fill="#35393E" />
                    <path d="M23.6394 30.3332V31.9242H22.6001V30.3204L20.8617 27.4331H21.9653L23.1648 29.4275L24.3642 27.4331H25.3837L23.6394 30.3332Z" fill="#35393E" />
                    <path d="M29.1415 30.9621H27.058L26.6625 31.9242H25.5985L27.5959 27.4331H28.6224L30.6297 31.9222H29.542L29.1415 30.9621ZM28.8152 30.1711L28.1032 28.4526L27.3912 30.1711H28.8152Z" fill="#35393E" />
                    <path d="M31.7386 27.4337H33.7776C34.2243 27.4247 34.6668 27.5202 35.07 27.7125C35.43 27.8852 35.7327 28.1577 35.9422 28.4976C36.1463 28.8575 36.2536 29.2641 36.2536 29.6778C36.2536 30.0914 36.1463 30.4981 35.9422 30.8579C35.7327 31.1978 35.43 31.4703 35.07 31.643C34.6671 31.8362 34.2244 31.932 33.7776 31.9228H31.7386V27.4337ZM33.7272 31.0695C34.1761 31.0695 34.5341 30.9442 34.8011 30.6937C35.0681 30.4432 35.1999 30.1044 35.1966 29.6773C35.1966 29.2501 35.0648 28.9113 34.8011 28.6608C34.5374 28.4103 34.1794 28.2854 33.7272 28.286H32.7779V31.0695H33.7272Z" fill="#35393E" />
                    <path d="M43.1129 27.6316C43.3886 27.7497 43.624 27.9455 43.7902 28.1952C43.9456 28.4567 44.0276 28.7553 44.0276 29.0594C44.0276 29.3636 43.9456 29.6621 43.7902 29.9236C43.6255 30.1749 43.3897 30.3715 43.1129 30.4882C42.7855 30.6262 42.4327 30.6936 42.0775 30.686H41.1727V31.924H40.1345V27.4338H42.0775C42.4328 27.4252 42.7858 27.4926 43.1129 27.6316ZM42.7312 29.6349C42.8134 29.5647 42.8783 29.4763 42.9206 29.3768C42.963 29.2773 42.9818 29.1694 42.9754 29.0614C42.9822 28.9524 42.9636 28.8433 42.9213 28.7426C42.8789 28.6419 42.8138 28.5524 42.7312 28.481C42.569 28.3491 42.332 28.2832 42.0202 28.2832H41.1727V29.8416H42.0202C42.332 29.8409 42.569 29.773 42.7312 29.6379V29.6349Z" fill="#35393E" />
                    <path d="M48.1387 30.9639H46.0543L45.6587 31.926H44.5938L46.5952 27.4369H47.6216L49.6289 31.926H48.5412L48.1387 30.9639ZM47.8114 30.1729L47.0995 28.4544L46.3875 30.1729H47.8114Z" fill="#35393E" />
                    <path d="M52.6129 30.3332V31.9242H51.5736V30.3204L49.8352 27.4331H50.9388L52.1382 29.4275L53.3377 27.4331H54.3572L52.6129 30.3332Z" fill="#35393E" />
                    <path
                        d="M58.7985 31.7021C58.4373 31.5115 58.1355 31.2252 57.9263 30.8745C57.7183 30.5102 57.6089 30.098 57.6089 29.6785C57.6089 29.259 57.7183 28.8468 57.9263 28.4826C58.1355 28.1319 58.4373 27.8455 58.7985 27.6549C59.1534 27.4763 59.5424 27.3757 59.9395 27.3596C60.3365 27.3436 60.7323 27.4126 61.1005 27.562C61.407 27.6951 61.678 27.8983 61.8916 28.1553L61.2241 28.7713C61.0877 28.6045 60.9154 28.4705 60.7201 28.3794C60.5247 28.2884 60.3114 28.2425 60.0959 28.2453C59.8361 28.2405 59.5795 28.3032 59.3513 28.4272C59.1371 28.5463 58.9607 28.723 58.842 28.9374C58.7218 29.167 58.6591 29.4223 58.6591 29.6815C58.6591 29.9406 58.7218 30.1959 58.842 30.4255C58.9604 30.6399 59.1369 30.8164 59.3513 30.9348C59.5793 31.0596 59.836 31.1226 60.0959 31.1177C60.3119 31.1202 60.5258 31.0737 60.7212 30.9815C60.9166 30.8894 61.0886 30.754 61.2241 30.5857L61.8916 31.2018C61.6789 31.4596 61.4077 31.663 61.1005 31.795C60.7656 31.9351 60.4055 32.0048 60.0425 31.9997C59.6094 32.0066 59.1816 31.9042 58.7985 31.7021Z"
                        fill="#35393E" />
                    <path
                        d="M64.0525 31.6982C63.6888 31.5076 63.3847 31.2206 63.1734 30.8686C62.9655 30.5064 62.8561 30.0962 62.8561 29.6786C62.8561 29.261 62.9655 28.8507 63.1734 28.4886C63.3847 28.1365 63.6888 27.8495 64.0525 27.659C64.4425 27.4607 64.8738 27.3574 65.3113 27.3574C65.7488 27.3574 66.1801 27.4607 66.5701 27.659C66.9361 27.8542 67.2422 28.1453 67.4556 28.501C67.669 28.8567 67.7817 29.2637 67.7817 29.6786C67.7817 30.0934 67.669 30.5004 67.4556 30.8561C67.2422 31.2119 66.9361 31.5029 66.5701 31.6982C66.1801 31.8964 65.7488 31.9998 65.3113 31.9998C64.8738 31.9998 64.4425 31.8964 64.0525 31.6982ZM66.0302 30.9319C66.2419 30.8121 66.4162 30.6358 66.5335 30.4226C66.6537 30.193 66.7164 29.9377 66.7164 29.6786C66.7164 29.4194 66.6537 29.1641 66.5335 28.9345C66.4159 28.7213 66.2418 28.5447 66.0302 28.4243C65.8096 28.3049 65.5626 28.2423 65.3118 28.2423C65.0609 28.2423 64.814 28.3049 64.5934 28.4243C64.3818 28.5447 64.2076 28.7213 64.0901 28.9345C63.9699 29.1641 63.9072 29.4194 63.9072 29.6786C63.9072 29.9377 63.9699 30.193 64.0901 30.4226C64.2074 30.6358 64.3816 30.8121 64.5934 30.9319C64.8138 31.0519 65.0608 31.1148 65.3118 31.1148C65.5628 31.1148 65.8098 31.0519 66.0302 30.9319Z"
                        fill="#35393E" />
                    <path d="M73.3107 27.4331V31.9222H72.4573L70.2196 29.1961V31.9222H69.1932V27.4331H70.0525L72.2843 30.1582V27.4331H73.3107Z" fill="#35393E" />
                    <path d="M75.9453 28.2815H74.5085V27.4331H78.4204V28.2795H76.9836V31.9222H75.9453V28.2815Z" fill="#35393E" />
                    <path d="M82.4809 31.9249L81.6157 30.6741H80.6595V31.9249H79.6212V27.4338H81.5673C81.9225 27.4252 82.2755 27.4926 82.6026 27.6316C82.8783 27.7497 83.1137 27.9455 83.2799 28.1952C83.4419 28.4546 83.5244 28.7557 83.5172 29.0614C83.5286 29.3641 83.4459 29.6628 83.2805 29.9166C83.1151 30.1703 82.8752 30.3666 82.5937 30.4783L83.6003 31.922L82.4809 31.9249ZM82.2179 28.4839C82.0557 28.3521 81.8188 28.2862 81.5069 28.2862H80.6595V29.8465H81.5069C81.8181 29.8465 82.0551 29.7783 82.2179 29.6418C82.2953 29.5665 82.3567 29.4765 82.3987 29.3771C82.4407 29.2777 82.4624 29.1708 82.4624 29.0629C82.4624 28.9549 82.4407 28.8481 82.3987 28.7487C82.3567 28.6492 82.2953 28.5592 82.2179 28.4839Z" fill="#35393E" />
                    <path
                        d="M85.8896 31.6982C85.5264 31.5073 85.2226 31.2204 85.0115 30.8686C84.8035 30.5064 84.6941 30.0962 84.6941 29.6786C84.6941 29.261 84.8035 28.8507 85.0115 28.4886C85.2226 28.1368 85.5264 27.8498 85.8896 27.659C86.2796 27.4607 86.7109 27.3574 87.1484 27.3574C87.5859 27.3574 88.0172 27.4607 88.4072 27.659C88.7697 27.8511 89.0734 28.1378 89.2862 28.4886C89.4958 28.8501 89.6062 29.2606 89.6062 29.6786C89.6062 30.0965 89.4958 30.507 89.2862 30.8686C89.0734 31.2193 88.7697 31.506 88.4072 31.6982C88.0172 31.8964 87.5859 31.9998 87.1484 31.9998C86.7109 31.9998 86.2796 31.8964 85.8896 31.6982ZM87.8673 30.9319C88.079 30.8121 88.2533 30.6358 88.3706 30.4226C88.4907 30.193 88.5535 29.9377 88.5535 29.6786C88.5535 29.4194 88.4907 29.1641 88.3706 28.9345C88.253 28.7213 88.0788 28.5447 87.8673 28.4243C87.6466 28.3049 87.3997 28.2423 87.1489 28.2423C86.898 28.2423 86.6511 28.3049 86.4305 28.4243C86.2191 28.545 86.0449 28.7215 85.9271 28.9345C85.807 29.1641 85.7442 29.4194 85.7442 29.6786C85.7442 29.9377 85.807 30.193 85.9271 30.4226C86.0447 30.6356 86.2189 30.8118 86.4305 30.9319C86.6509 31.0519 86.8979 31.1148 87.1489 31.1148C87.3998 31.1148 87.6468 31.0519 87.8673 30.9319Z"
                        fill="#35393E" />
                    <path d="M91.0284 27.4331H92.0667V31.0748H94.3213V31.9222H91.0284V27.4331Z" fill="#35393E" />
                    <path d="M95.5455 27.4331H96.5837V31.0748H98.8353V31.9222H95.5455V27.4331Z" fill="#35393E" />
                    <path d="M103.536 31.0916V31.9262H100.059V27.4331H103.451V28.2667H101.092V29.2416H103.176V30.0495H101.092V31.0916H103.536Z" fill="#35393E" />
                    <path d="M107.863 31.9249L106.997 30.6741H106.042V31.9249H105.001V27.4338H106.944C107.3 27.4253 107.653 27.4927 107.98 27.6316C108.256 27.7497 108.491 27.9455 108.657 28.1952C108.819 28.4544 108.902 28.7556 108.894 29.0614C108.906 29.3642 108.823 29.6632 108.658 29.917C108.493 30.1709 108.252 30.367 107.97 30.4783L108.977 31.922L107.863 31.9249ZM107.601 28.4839C107.438 28.3521 107.2 28.2862 106.889 28.2862H106.042V29.8465H106.889C107.2 29.8465 107.438 29.7783 107.601 29.6418C107.678 29.5663 107.739 29.4762 107.78 29.3768C107.822 29.2774 107.844 29.1707 107.844 29.0629C107.844 28.955 107.822 28.8483 107.78 28.7489C107.739 28.6495 107.678 28.5594 107.601 28.4839Z" fill="#35393E" />
                    <defs>
                        <linearGradient id="paint0_linear_244_4267" x1="0.017095" y1="10.7613" x2="109.827" y2="10.7613" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#58A0FF" />
                            <stop offset="0.45" stop-color="#5888FF" />
                            <stop offset="1" stop-color="#5966FF" />
                        </linearGradient>
                        <linearGradient id="paint1_linear_244_4267" x1="0.017095" y1="10.7613" x2="109.827" y2="10.7613" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#58A0FF" />
                            <stop offset="0.45" stop-color="#5888FF" />
                            <stop offset="1" stop-color="#5966FF" />
                        </linearGradient>
                        <linearGradient id="paint2_linear_244_4267" x1="0.017095" y1="10.7613" x2="109.827" y2="10.7613" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#58A0FF" />
                            <stop offset="0.45" stop-color="#5888FF" />
                            <stop offset="1" stop-color="#5966FF" />
                        </linearGradient>
                        <linearGradient id="paint3_linear_244_4267" x1="0.017095" y1="10.7613" x2="109.827" y2="10.7613" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#58A0FF" />
                            <stop offset="0.45" stop-color="#5888FF" />
                            <stop offset="1" stop-color="#5966FF" />
                        </linearGradient>
                        <linearGradient id="paint4_linear_244_4267" x1="0.017095" y1="10.7613" x2="109.827" y2="10.7613" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#58A0FF" />
                            <stop offset="0.45" stop-color="#5888FF" />
                            <stop offset="1" stop-color="#5966FF" />
                        </linearGradient>
                    </defs>
                </svg>
            </a>
            <a href="tel:+380934111411">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
                    <path d="M25.7517 23.4403L23.6425 25.5325C23.3311 25.8518 22.9184 25.96 22.5165 25.9605C20.7391 25.9072 19.0591 25.0342 17.6797 24.1377C15.4155 22.4905 13.338 20.448 12.0341 17.9797C11.534 16.9447 10.9472 15.6241 11.0033 14.4688C11.0083 14.0342 11.1254 13.6077 11.4314 13.3276L13.5406 11.2195C13.9786 10.8469 14.4022 10.9757 14.6824 11.4097L16.3793 14.6273C16.5579 15.0085 16.4554 15.417 16.189 15.6893L15.4119 16.466C15.3639 16.5317 15.3334 16.6065 15.3326 16.6879C15.6306 17.8414 16.5333 18.9045 17.3308 19.6361C18.1282 20.3678 18.9854 21.359 20.0981 21.5937C20.2356 21.632 20.4041 21.6455 20.5025 21.554L21.4064 20.6347C21.7181 20.3985 22.168 20.2831 22.5007 20.4762H22.5165L25.5772 22.2832C26.0265 22.5648 26.0734 23.1091 25.7517 23.4403Z" fill="#5888FF" />
                    <rect x="1" y="1" width="34" height="34" rx="3" stroke="#5888FF" stroke-width="2" />
                </svg>
            </a>

        </header>
    </div>

    <div class="container">
        <main>
            <section class="top">
                <div class="title">
                    <h1>{{$user->title??'СПЛАТИТИ АБО ОТРИМАТИ ФІСКАЛЬНИЙ ЧЕК'}}</h1>
                    <p>{{$device->address}}</p>
                </div>

                <form id="paymentForm" method="POST" action="{{route('go_payment', $device->device_hash)}}">
                    @csrf
                    <div class="payment">
                        <h2>{{$device->place_name}}</h2>
                        @if($device->enable_payment)
                            <input type="hidden" name="system" value="{{$device->payment_system->system}}">

                            <div class="input" style="display: none">
                                <button type="button" id="decrement">-</button>
                                <input type="tel" id="amount_field" placeholder="100" value="" name="amount">
                                <button type="button" id="increment">+</button>
                            </div>

                            <p>оберіть суму для поповнення</p>
                            <div class="input-buttons">
                                <button type="button">10</button>
                                <button type="button">20</button>
                                <button type="button">50</button>
                                <button type="button">100</button>
                                <button type="button">200</button>
                            </div>
                        @endif
                    </div>

                    <div class="buttons">
                        {{--              <button>Сплатити по NFC</button>--}}
                        @if($device->enable_payment)
                            <button type="button" id="goPayment">Сплатити карткою</button>

                            @if($errors->any())
                                <p class="cntrlmsg" style="color:red;">{{$errors->first()}}</p>
                            @endif

                        @endif
                    </div>
                </form>
            </section>

            <section class="transactions">
                <h2>Останні транзакції</h2>

                <table>
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Сума</th>
                        <th>Чек</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($last_three as $check)
                        <tr>
                            <td>{{\Carbon\Carbon::parse($check->date)->format('d.m.Y - H:i')}}</td>
                            <td>{{$check->sales_cashe / 100}} грн.</td>
                            <td>
                                @if($check->fiskalized==1 && $check->check_code)
                                    <a href="https://check.checkbox.ua/{{$check->check_code}}">
                                        <button>Отримати</button>
                                    </a>
                                @elseif($device->not_fiscal_cash && $check->cash == 1)
                                    <a  href="#" class="js-send-to-fiscal" data-id="{{$check->id}}">
                                        <img width="20px" style="display: none" src="{{ asset('img/load.gif') }}" >
                                        <button style="background: gray">
                                            Отримати
                                        </button>
                                    </a>
                                @else
                                    <a  href="{{route('temp-receipt',['hash'=>$hash,'id'=>$check->id])}}">
                                        <button style="background: gray">Отримати</button>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <p>{{$device_code}}</p>
            </section>
        </main>
    </div>

    <footer>
        <div class="links">
            <a href="{{route('privacy-policy',['id'=>$user->id])}}">Політика конфідеційності</a>
            <a href="{{route('oferta',['id'=>$user->id])}}">Договір оферти</a>
            <a href="{{route('about-us',['id'=>$user->id])}}">Про нас</a>
        </div>
        <p>© Copyright <?=date('Y');?>. All Rights Reserved.</p>
    </footer>
</div>

<script>
    try {
        const increment = document.querySelector("#increment");
        const decrement = document.querySelector("#decrement");
        const fixButtons = document.querySelectorAll(".input-buttons button");
        const input = document.querySelector(".input input");

        increment.onclick = () => {
            input.value = +input.value + 10;
        }

        decrement.onclick = () => {
            input.value = +input.value - 10;

            if (input.value <= 0) {
                input.value = 0;
            }
        }

        fixButtons.forEach(item => {
            item.onclick = () => {
                input.value = item.textContent;
                $(fixButtons).removeClass('active');
                $(item).addClass('active');

            }
        })
    } catch {
        console.log("Errors with input buttons")
    }
</script>
<script>
    var divideBy = @json($device->divide_by);
</script>

<script>

    $(document).ready(function(){

        $('.js-send-to-fiscal').click(function(e){
            e.preventDefault();
            let id = $(this).data('id');
            let hash = '{{$hash}}';
            let block = $(this);
            $(block).find('img').show();
            $(block).find('button').hide();

            $.post('/fiscalization-check', {
                id:id,
                hash:hash
            }, function(resp){
                if(resp.link){
                    window.location.href = resp.link;
                }
            });
        });

        $("#goPayment").click(function(){

            var amount_field = $("#amount_field");
            let sum = $(amount_field).val();
            let divideBy = window.divideBy; // Use the value from PHP

            if (sum === "" || parseFloat(sum) === 0) {
                alert('Сума не може бути порожньою або дорівнює нулю');
                return;
            }

            if (sum % divideBy !== 0) {
                alert('Сума не кратна '+divideBy);
                return;
            }

            let controller = '{{$hash}}';
            let button = $(this);
            let form = $("#paymentForm");


            $(this).after('<p class="cntrlmsg">Очікування відповіді від контроллера 10...');
            $(this).hide();

            $.get(`/check/${controller}/reserve_payment`);

            let cnt = 9;

            var checkPaymentInrerval = setInterval(function () {
                $.get(`/check/${controller}/check_allow_payment`, function (resp) {
                    //resp.msg = "BUSY";
                    //resp.success = true;
                    if (resp.success) {
                        if (resp.msg == "OK") {
                            $(form).submit();
                        }
                        if (resp.msg == "BUSY") {
                            $('p.cntrlmsg').html('Контроллер відхилив запит на оплату.<br>Спробуйте через 20 сек');
                            $('p.cntrlmsg').css('color', 'red');

                            var disallowTimeout = 19;

                            var disallowPayment = setInterval(function(){

                                if(disallowTimeout == 0)
                                {
                                    $('p.cntrlmsg').remove();
                                    $("#goPayment").show();
                                    clearInterval(disallowPayment);
                                    return;
                                }

                                $('p.cntrlmsg').html(`Контроллер відхилив запит на оплату.<br>Спробуйте через ${disallowTimeout} сек`);

                                disallowTimeout = disallowTimeout - 1;

                            }, 1000);

                        }
                        clearInterval(checkPaymentInrerval);
                    } else {

                        if(cnt == 0)
                        {
                            clearInterval(checkPaymentInrerval);
                            $('p.cntrlmsg').html('Не дочекались відповіді від контроллера.<br>Спробуйте через 120 сек');
                            $('p.cntrlmsg').css('color', 'red');

                            var chAgain = 19;

                            var asdTime = setInterval(function(){

                                if(chAgain == 0)
                                {
                                    $('p.cntrlmsg').remove();
                                    $("#goPayment").show();
                                    clearInterval(asdTime);
                                    return;
                                }

                                $('p.cntrlmsg').html(`Не дочекались відповіді від контроллера.<br>Спробуйте через ${chAgain} сек`);

                                chAgain = chAgain - 1;

                            }, 1000);

                            return;
                        }

                        $('p.cntrlmsg').text(`Очікування відповіді від контроллера ${cnt}...`);

                        cnt = cnt - 1;

                    }


                });
            }, 1000);

        });

    });

</script>
<script>
    function checkPageShow(event) {
        if (event.persisted || window.performance && window.performance.navigation.type === 2) {

            window.location.reload();
        }
    }
    window.addEventListener('pageshow', checkPageShow);
</script>
<script>
    function checkPageShow(event) {
        if (event.persisted || window.performance && window.performance.navigation.type === 2) {

            window.location.reload();
        }
    }
    window.addEventListener('pageshow', checkPageShow);
</script>
</body>

</html>
