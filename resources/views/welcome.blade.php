@extends('layouts.app')

@section('content')
    <div id="container">
        <div id="contents" style="margin-bottom: 20px;">
            <h2 id="page_title" class="page_title">上位１５サイトの記事をまとめる</h2>
            <center id="input_search_box" >
                <INPUT size="80" type="search" id = "search_text" onsearch="search()" class="sample1"></INPUT>
                <button  type="button" class ="btn-primary" onclick="search()" name="検索" >検索</button>
            </center>
            <center>
                <div rows="60" cols="100" class="sample3" id="search_contents"></div>
                <!-- <TEXTAREA rows="60" cols="100" class="sample3"></TEXTAREA> -->
            </center>
        </div>
    </div>
@endsection
   <!--  <script type="text/javascript">
        var header_height = document.getElementById("header");
        header_height = (header_height == null  ? 0 : header_height.offsetHeight);
        console.log(header_height);
        var title_height = document.getElementById("page_title").offsetHeight;
        var search_height = document.getElementById("input_search_box").offsetHeight;
        var footer_height = document.getElementById("footer").offsetHeight;
        var content_height = window.innerHeight - header_height - title_height - search_height - footer_height- 45;
        document.getElementById("search_contents").setAttribute("style", "min-height: "+ content_height +"px");
    </script> -->
</html>
