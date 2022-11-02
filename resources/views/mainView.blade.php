<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Керамир парсер</title>
    <link rel="stylesheet" href={{ asset('static/css/bootstrap.min.css') }}>
    <script src="{{ asset('static/js/bootstrap.min.js') }}"></script>
</head>

<body>
<div class="container mt-5 d-flex justify-content-center">
    <div class="row g-3  justify-content-center align-self-center w-25">
        <form action="{{ route('file-import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-auto">
                <label for="inputPassword6" class="col-form-label">Керамир парсер</label>
            </div>
            <div class="col-auto">
                <input type="file" id="file" name="file" class="form-control">
            </div>
            <div class="col-auto">
                @if (count($errors) > 0)
                    @foreach ($errors->all() as $error)
                        <span class="form-text">
                     {{$error}}
                    </span>
                    @endforeach
                @endif
            </div>
            <div class="pt-3">
                <button class="btn btn-primary">Загрузить excel</button>
            </div>
        </form>
    </div>
</div>


<div class="container align-items-center w-25 pt-5">
    <p>Парсер принимает следющие сайты:</p>
    <ul class="list-group">
        <li class="list-group-item">kafel-online.ru</li>
        <li class="list-group-item">www.maxidom.ru</li>
        <li class="list-group-item">keramodecor.ru</li>
        <li class="list-group-item">trendkeramika.ru</li>
        <li class="list-group-item">stroysnab66.ru</li>
        <li class="list-group-item">a-keramika96.ru</li>
        <li class="list-group-item">mega-kafel.ru</li>
        <li class="list-group-item">www.akro-pol.ru</li>
        <li class="list-group-item">mozaic96.ru</li>
    </ul>
</div>


<div class="container mt-5 text-center">
    <div class="p-4">
        Парсер принимает excel файл вида:
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Код</th>
            <th scope="col">Название</th>
            <th scope="col">kafel-online.ru</th>
            <th scope="col">mozaic96.ru и тд</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">54385</th>
            <td>Декор настенный Гинардо</td>
            <td>
                https://kafel-online.ru/catalog/keramicheskaia-plitka/kerama-marazzi/ginardo/dekor_300_600_ginardo_seryy_os_b10_11037r_4/
            </td>
            <td>
                https://mozaic96.ru/store/keramicheskaya-plitka/dlya-vannoy/kerama_marazzi_1/ginardo/ginardo-seryy-obreznoy-11153r//
            </td>
        </tr>
        <tr>
            <th scope="row">68153</th>
            <td>Керамогранит Буранелли</td>
            <td>
                https://kafel-online.ru/catalog/keramicheskaia-plitka/kerama-marazzi/buranelli/keramogranit_200_231_buranelli_belyy_sg23000n_57_0_76/
            </td>
            <td>
                https://mozaic96.ru/store/keramogranit/dlya-pola/kerama_marazzi/buranelli/astoriya-belyy-obreznoy-12105r-3-5-10-11/
            </td>
        </tr>
        <tr>
            <th scope="row">и тд</th>
            <td colspan="2">и тд</td>
            <td>и тд</td>
        </tr>
        </tbody>
    </table>
</div>


</body>

</html>
