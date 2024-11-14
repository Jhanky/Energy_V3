@extends('layouts.main')
@section('header')
<style>
    :root {
        /* Colores de bolas */
        --color-box1: #8ff638;
        --color-box2: #8ff638;
        --color-box3: #8ff638;
        --color-box4: #8ff638;

        /* Variables desplazamiento bolas */
        --size-balls: 10vmin;
        --size-container: 30vmin;
        --desp: calc(var(--size-container) - var(--size-balls));
        --desp-neg: calc(var(--size-balls) - var(--size-container))
    }

    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {
        height: 100vh;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #ffffff;
    }

    .container {
        width: var(--size-container);
        height: var(--size-container);
        display: flex;
        position: relative;
    }

    .ball {
        width: var(--size-balls);
        height: var(--size-balls);
        border-radius: 50%;
        position: absolute;
        /* offset-x | offset-y | blur-radius | color */
        box-shadow: 1rem 1rem 1rem rgba(0, 0, 0, 0.6);
    }

    .ball1 {
        background: var(--color-box3);
        top: 0;
        left: 0;
        /* Animación bola 1 */
        animation: moveBall1 2s infinite linear;
    }

    .ball2 {
        background: var(--color-box4);
        top: 0;
        right: 0;
        /* Animación bola 2 */
        animation: moveBall2 2s infinite linear;
    }

    .ball3 {
        background: var(--color-box1);
        bottom: 0;
        right: 0;
        /* Animación bola 3 */
        animation: moveBall3 2s infinite linear;
    }

    .ball4 {
        background: var(--color-box2);
        bottom: 0;
        left: 0;
        /* Animación bola 4 */
        animation: moveBall4 2s infinite linear;
    }

    /* Keyframes de animación */
    @keyframes moveBall1 {
        0% {
            transform: translate(0, 0);
            opacity: 1;
        }

        25% {
            transform: translate(var(--desp), 0);
            opacity: 0.5;
        }

        50% {
            transform: translate(var(--desp), var(--desp));
            opacity: 0.3;
        }

        75% {
            transform: translate(0, var(--desp));
            opacity: 0.5;
        }

        100% {
            transform: translate(0, 0);
            opacity: 1;
        }
    }

    @keyframes moveBall2 {
        0% {
            transform: translate(0, 0);
            opacity: 0.3;
        }

        25% {
            transform: translate(0, var(--desp));
            opacity: 0.5;
        }

        50% {
            transform: translate(var(--desp-neg), var(--desp));
            opacity: 1;
        }

        75% {
            transform: translate(var(--desp-neg), 0);
            opacity: 0.5;
        }

        100% {
            transform: translate(0, 0);
            opacity: 0.3;
        }
    }

    @keyframes moveBall3 {
        0% {
            transform: translate(0, 0);
            opacity: 1;
        }

        25% {
            transform: translate(var(--desp-neg), 0);
            opacity: 0.5;
        }

        50% {
            transform: translate(var(--desp-neg), var(--desp-neg));
            opacity: 0.3;
        }

        75% {
            transform: translate(0, var(--desp-neg));
            opacity: 0.5;
        }

        100% {
            transform: translate(0, 0);
            opacity: 1;
        }
    }

    @keyframes moveBall4 {
        0% {
            transform: translate(0, 0);
            opacity: 0.3;
        }

        25% {
            transform: translate(0, var(--desp-neg));
            opacity: 0.5;
        }

        50% {
            transform: translate(var(--desp), var(--desp-neg));
            opacity: 1;
        }

        75% {
            transform: translate(var(--desp), 0);
            opacity: 0.5;
        }

        100% {
            transform: translate(0, 0);
            opacity: 0.3;
        }
    }

    /* Estilos para la pantalla de carga */
    #loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0);
        /* Fondo transparente */
        z-index: 9999;
        /* Z-index alto para asegurar que esté por encima de otros elementos */
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

@endsection
@section('title')
Loadin...
@endsection

@section('base')
<main>
    <div id="loading-overlay" class="loading-overlay">
        <div class="container">
            <div class="ball1 ball"></div>
            <div class="ball2 ball"></div>
            <div class="ball3 ball"></div>
            <div class="ball4 ball"></div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    // Mostrar la pantalla de carga al inicio de la carga de la página
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('loading-overlay').classList.add('active');
    });
    // Ocultar la pantalla de carga al finalizar la carga de la página
    window.addEventListener('load', function() {
        document.getElementById('loading-overlay').classList.remove('active');
    });
</script>
@endsection