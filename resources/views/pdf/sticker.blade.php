<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{--        <link href="{{ asset('css/sticker-pdf.css') }}" rel="stylesheet" type="text/css" />--}}
    <style>
        html {
            margin: 6px;
        }

        body {
            font-size: 6px;
            font-family: 'DejaVu Sans', sans-serif;
        }

        .label {
            font-weight: bold;
            display: inline;
            margin: 0;
            padding: 0;
        }

        h4 {
            margin: 0 0;
            font-size: 8px;
        }

        div {
            margin-bottom: 1px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
@foreach($stickers as $sticker)
    @if($loop->last)
        <div style="display: flex;flex-direction: column;justify-content: space-between;height: calc(100vh - 5px)">
            @else
                <div style="display: flex;flex-direction: column;justify-content: space-between;height: calc(100vh - 5px)" class="page-break">
                    @endif
                    @if($sticker->code)
                        <h4>{{$sticker->code}}</h4>
                    @endif
                    @if($sticker->barcode)
                        <h4>{{$sticker->barcode}}</h4>
                    @endif
                    @if($sticker->name)
                        <h4 style="margin-bottom: 5px;">{{$sticker->name}}</h4>
                    @endif
                    @if($sticker->composition)
                        <div><span class="label">Tərkibi: </span>
                            {{$sticker->composition}}
                        </div>
                    @endif
                    @if($sticker->manufacturer)
                        <div>
                            <span class="label">İstehsalçı şirkət: </span>
                            {{$sticker->manufacturer}}
                        </div>
                    @endif

                    @if($sticker->manufacturer_country)
                        <div>
                            <span class="label">Mənşə ölkə: </span>
                            {{$sticker->manufacturer_country}}
                        </div>
                    @endif


                    <div style="margin-top: 2px;">
                        <span class="label">İdxalçı: </span>
                        ASG Business Aviation MMC, AZ 1044,<br>
                        Heydər Əliyev Beynəlxalq Hava Limanı<br>
                        Tel: 012 5048282<br>
                        Məhsulun istehsal və son istifadə<br>
                        tarixləri qablaşdırmanın üzərində qeyd olunmuşdur
                    </div>
                </div>

        @endforeach


</body>
</html>
