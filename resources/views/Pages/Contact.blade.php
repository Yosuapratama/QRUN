<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Qrun Website</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="description"
        content="Contact QRUN for support, inquiries, or more information about our QR code services. We're here to help.">
    <meta name="keywords"
        content="contact QRUN, QRUN support, QRUN help, get in touch with QRUN, QRUN customer service, QRUN inquiries, qrun">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body class="bg-gray-50">
    <!-- Navbar -->
    @include('Components.Navbar')
    
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-600 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">
                Hubungi Kami
            </h1>
            <p class="text-xl text-blue-100 mb-8">
                Kami siap membantu Anda memulai perjalanan blogging yang luar biasa
            </p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-1 gap-12">
                <!-- Contact Information -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">
                        Mari Terhubung
                    </h2>
                    <p class="text-lg text-gray-600 mb-8">
                        Punya pertanyaan tentang platform kami? Ingin bergabung dengan komunitas blogger?
                        Atau butuh bantuan teknis? Jangan ragu untuk menghubungi kami!
                    </p>

                    <!-- Email Contact -->
                    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-envelope text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">Email Kami</h3>
                                <p class="text-gray-600">Kirim email langsung untuk pertanyaan atau bantuan</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div
                                class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div>
                                    <h4 class="font-medium text-gray-900">Support Umum</h4>
                                    <p class="text-sm text-gray-600">Untuk pertanyaan umum dan bantuan</p>
                                </div>
                                <a href="mailto:qrunonline@gmail.com"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    qrunonline@gmail.com
                                </a>
                            </div>

                            <div
                                class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div>
                                    <h4 class="font-medium text-gray-900">Tim Teknis</h4>
                                    <p class="text-sm text-gray-600">Untuk masalah teknis dan bug report</p>
                                </div>
                                <a href="mailto:qrunonline@gmail.com"
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                    <i class="fas fa-tools mr-2"></i>
                                    qrunonline@gmail.com
                                </a>
                            </div>

                            <div
                                class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div>
                                    <h4 class="font-medium text-gray-900">Kemitraan</h4>
                                    <p class="text-sm text-gray-600">Untuk kerjasama dan partnership</p>
                                </div>
                                <a href="mailto:qrunonline@gmail.com"
                                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                    <i class="fas fa-handshake mr-2"></i>
                                    qrunonline@gmail.com
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Tips -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-3">
                            <i class="fas fa-lightbulb mr-2"></i>
                            Tips Menghubungi Kami
                        </h3>
                        <ul class="space-y-2 text-blue-800">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-blue-600 mt-1 mr-2"></i>
                                <span>Sertakan detail lengkap masalah yang Anda alami jika terjadi masalah</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-blue-600 mt-1 mr-2"></i>
                                <span>Lampirkan screenshot jika diperlukan</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-blue-600 mt-1 mr-2"></i>
                                <span>Kami akan merespon dalam secepat mungkin</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    Pertanyaan yang Sering Diajukan
                </h2>
                <p class="text-lg text-gray-600">
                    Temukan jawaban untuk pertanyaan umum sebelum menghubungi kami
                </p>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-lg">
                    <button class="w-full px-6 py-4 text-left flex items-center justify-between faq-button">
                        <span class="font-medium text-gray-900">Bagaimana cara memulai di platform ini?</span>
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </button>
                    <div class="px-6 pb-4 hidden faq-content">
                        <p class="text-gray-600">
                            Untuk memulai memasang tempat, Anda perlu mendaftar akun terlebih dahulu, kemudian menunggu approval dari tim kami.
                            Setelah itu, Anda bisa mengakses dashboard, membuat tempat yang,
                            dan mulai menulis konten pertama Anda. Terdapat juga video bagaimana penggunaan website ini.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg">
                    <button class="w-full px-6 py-4 text-left flex items-center justify-between faq-button">
                        <span class="font-medium text-gray-900">Apakah platform ini gratis?</span>
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </button>
                    <div class="px-6 pb-4 hidden faq-content">
                        <p class="text-gray-600">
                            Kami menyediakan paket gratis dengan fitur dasar tapi bermanfaat.
                            jikalau anda membutuhkan untuk mengelola lebih dari 1 silahkan hubungi tim kami melalui email diatas.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg">
                    <button class="w-full px-6 py-4 text-left flex items-center justify-between faq-button">
                        <span class="font-medium text-gray-900">Setelah itu apa yang bisa saya lakukan?</span>
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </button>
                    <div class="px-6 pb-4 hidden faq-content">
                        <p class="text-gray-600">
                            Anda dapat melakukan visit terhadap tempat yang telah Anda buat, mengelola konten, dan informasi. anda juga dapat mencetak barcode QR untuk tempat Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('Components.FooterHome')

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // FAQ Toggle
        const faqButtons = document.querySelectorAll('.faq-button');
        faqButtons.forEach(button => {
            button.addEventListener('click', () => {
                const content = button.nextElementSibling;
                const icon = button.querySelector('i');

                content.classList.toggle('hidden');
                icon.classList.toggle('fa-chevron-down');
                icon.classList.toggle('fa-chevron-up');
            });
        });

        // Form submission
        const contactForm = document.querySelector('form');
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Get form data
            const formData = new FormData(contactForm);
            const data = Object.fromEntries(formData);

            // Simple validation
            if (!data.firstName || !data.lastName || !data.email || !data.subject || !data.message) {
                alert('Mohon lengkapi semua field yang wajib diisi.');
                return;
            }

            if (!data.privacy) {
                alert('Mohon setujui kebijakan privasi dan syarat layanan.');
                return;
            }

            // Simulate form submission
            alert('Terima kasih! Pesan Anda telah terkirim. Kami akan merespon dalam 24 jam.');
            contactForm.reset();
        });
    </script>
</body>

</html>
