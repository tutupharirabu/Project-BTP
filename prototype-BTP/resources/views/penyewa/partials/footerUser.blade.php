<footer class="footer border-top">
    <div class="container d-flex justify-content-center align-items-center">
        <div class="footer-logo d-flex align-items-center">
            <img src="{{ asset('assets/img/logospacerentwobg.png') }}" alt="Logo Telkom University"
                class="footer-logo-img">
        </div>
        <div class="footer-copyright text-dark">
            © Copyrights 2024. All rights reserved
        </div>
    </div>
</footer>

<style>
    .footer {
        background-color: #EDEDED;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 56px;
        /* Atur tinggi footer */
    }

    .footer .container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
        /* Menghilangkan padding agar sesuai dengan tinggi footer */
    }

    .footer-logo {
        display: flex;
        align-items: center;
        margin-right: 10px;
        /* Tambahkan jarak antara logo dan teks hak cipta */
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
