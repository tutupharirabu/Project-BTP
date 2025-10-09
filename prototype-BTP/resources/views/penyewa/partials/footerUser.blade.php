<footer class="footer border-top mt-auto w-100">
    <div class="container d-flex justify-content-center align-items-center gap-3">
        <div class="footer-logo d-flex align-items-center">
            <img src="{{ asset('assets/img/logo_nav.png') }}" alt="Logo Telkom University" class="footer-logo-img">
            <img src="{{ asset('assets/img/BTP-Telkom.png') }}" alt="Logo Telkom University" class="footer-logo-img">
        </div>
        <div class="footer-copyright text-dark">
            © Copyrights 2025. All rights reserved
        </div>
    </div>
</footer>

<style>
    .footer {
        background-color: #EDEDED;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        padding: 12px 0;
        margin-top: 2rem;
    }

    .footer .container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
    }

    .footer-logo {
        display: flex;
        align-items: center;
        margin-right: 10px;
    }

    .footer-logo-img {
        height: 36px;
        margin-right: 10px;
    }

    .footer-logo-text {
        font-size: px;
        color: #333;
    }

    .footer-logo-text,
    .footer-logo-img {
        display: inline-flex;
        align-items: center;
    }

    .footer-logo-text+.footer-logo-text {
        margin-left: 0.5rem;
        /* Jarak antara logo dan teks */
    }

    .footer-copyright {
        font-size: 14px;
        color: #666;
    }
</style>
