@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="text-center mt-5">
        <p class="fs-5">子どもの「課題やお手伝い」へのモチベーションをサポートしながら、<br>タスク管理をするサービスです。</p>
        <p class="fs-5">1対1のルームを作成後、<br>ルーム内で課題作成や報酬作成等が可能です。</p>
    </div>
    @guest
        <div class="row justify-content-around text-center mt-5">
            <div class="col-4">
                <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="{{ route('login') }}">
                    <i class="fa-solid fa-right-to-bracket fa-2x"></i>
                    <span class="fs-5 align-top">ログイン</span>
                </a>
            </div>
            <div class="col-4">
                <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="{{ route('register') }}">
                    <i class="fa-solid fa-user-plus fa-2x"></i>
                    <span class="fs-5 align-top">ユーザー登録</span>
                </a>
            </div>
        </div>
    @endguest
    <div class="text-center mt-5">
        <img src="{{ asset('images/top_image.png') }}" class="img-fluid" alt="">
    </div>
</div>
@endsection
