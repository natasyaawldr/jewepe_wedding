 <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-2 text-dark mb-4 animated slideInDown">Detail Paket</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('');?>">Home</a></li>
                    <li class="breadcrumb-item text-dark" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
    </div>
<!-- Page Header End -->

<!-- Article Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5 wow fadeIn" data-wow-delay="0.15">
                <img class="img-fluid" src="<?= base_url('assets/file/katalog/') . $katalog->image; ?>" alt="">
            </div>
            <div class="col-lg-7 wow fadeIn" data-wow-delay="0.55">
                <div class="section-title">
                    <p class="fs-5 fw-medium fst-italic text-primary">JeWePe Wedding Organizer</p>
                    <?= $this->session->flashdata('message'); ?>
                    <h1 class="display-6"><?= $katalog->package_name; ?></h1>
                </div>
                <p><?= $katalog->description; ?></p>
                <h3 class="text-primary">RP. <?= number_format($katalog->price, 2, ",", "."); ?></h3>
                <div class="ms-auto wow fadeInUp" data-wow-delay="0.1s">
                    <h4 class="mb-4">Tertarik Paket ini? Yuk langsung Pesan</h4>
                    <form action="<?= base_url('Beranda/pesan'); ?>" method="post">
                     <input type="hidden" name="id" value="<?= $this->input->get('id'); ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama Anda" required>
                                    <label for="name">Nama Anda</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Alamat Email" required>
                                    <label for="email">Alamat Email</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="phone" name="phone_number" placeholder="No Handphone" required>
                                    <label for="phone">No Handphone</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="wedding_date" name="wedding_date" placeholder="Tanggal Pernikahan" required>
                                    <label for="wedding_date">Tanggal Pernikahan</label>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <button class="btn btn-primary rounded-pill py-3 px-5" type="submit">Pesan paket</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
