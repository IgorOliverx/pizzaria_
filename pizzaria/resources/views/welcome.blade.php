<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            /* body {
                margin: 0;
            }
            .container{
                margin-top: 100px;
                margin-left: 5%;
                width: 90%;
                height: 400px;
                position: absolute;
               
            }
            .header-cabecalho{
                width: 100%;
                height: 80px;
                background-color: transparent;
            }
            .body{
                width: 1390px;
                width: 100%;
                height: 2000px;
                height: 100%;
                background: rgb(0,0,0);
                background: linear-gradient(180deg, rgba(0,0,0,1) 0%, rgba(0,0,0,1) 35%, rgba(13,0,26,1) 100%); 
            } */
            
body {
    margin: 0;
    background: rgb(0,1,2);
    
}

header {
    position: fixed;
    display: flex;
    height: 70px;
    width: 100%;
    justify-content: space-between;
    align-items: center;
    padding: 0 40px 0 25px;
    background-color: transparent;
    color: white;
}
.logoMenu {
    max-width: 180px;
    min-width: 150px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 10px;
    

}

#left {
    display: flex;
    justify-content: start;
    align-items: center;
    width: 800px;
}


#headerUl {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    width: 100%;
    list-style: none;
    margin-left: 20px;
}

#headerUl li {
    display: flex;
    padding: 10px 10px;
    cursor: pointer;
    border-radius: 4px;
    font-family: 'Segoe UI',Helvetica,Arial,sans-serif;
    font-weight: 500;
    font-size: 14px;
}

#headerUl li:last-child {
    display: none;
    width: 40px;
    justify-content: center;
}


li .arows {
    margin-left: 5px;
}




@media screen  and (max-width: 1150px) {
    ul#headerUl li:nth-child(5) {
        display: none;
    }
    ul#headerUl li:last-child {
        display: flex;
    }
}
@media screen  and (max-width: 1100px) {
    ul#headerUl li:nth-child(4) {
        display: none;
    }
}
@media screen  and (max-width: 1000px) {
    ul#headerUl li:nth-child(3) {
        display: none;
    }
}
@media screen  and (max-width: 850px) {
    ul#headerUl {
        display: none;
    }
}


@media screen and (max-width: 540px) {
    .logoMenu img, div#right span, #createDesign {
        display: none;
    }
    #left {
        width: 20%;
    }

  
}

        </style>
    </head>
    <body>
        <main class="body">

       
          
 <header>
        <div id="left">
            <div  class="logoMenu">
                <x-application-logo style="width: 150px; height: 60px"/>
            </div>
            <ul id="headerUl">
                <li class="menuItem">Cardápio</li>
                <li class="menuItem">Pedidos</li>
                <li class="menuItem">About</li>
                
                @if (Route::has('login'))
                    @auth
                    <li class="menuItem"><a href="{{ url('/dashboard') }}" >Dashboard</a></li>
                    @else

                    <li class="menuItem"> <a href="{{ route('login') }}" >Login</a></li>

                        @if (Route::has('register'))
                        <li class="menuItem">  <a href="{{ route('register') }}" >Cadastro</a></li>
                        @endif
                    @endauth
                    @endif
                <li class="menuItem" id="moreMenu">...</li>
            </ul>
            
        </div>
       
    </header>
   
            <div class="container"> 
                conteudo
            </div>
            </main>
    </body>
</html>
