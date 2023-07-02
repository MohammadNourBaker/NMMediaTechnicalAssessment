<?= $this->extend('components/layout') ?>

<?= $this->section('body') ?>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm8- offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white from-wrapper">
                <div class="container">
                    <h3>Email verify</h3>
                    <hr>
                    <?php if (session()->get('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->get('success') ?>
                        </div>
                    <?php endif; ?>
                    <form class="" action="/auth/verify-email" method="post">
                        <div class="form-group">
                            <label for="email">Code</label>
                            <input type="text" class="form-control" name="otp_code" id="email"
                                   value="<?= set_value('otp_code') ?>">
                        </div>
                        <?php if (session()->get('validation')): ?>
                            <div class="col-12">
                                <div class="alert alert-danger" role="alert">
                                        <?= session()->get('validation') ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->get('sent')): ?>
                            <div class="col-12">
                                <div class="alert alert-success" role="alert">
                                        <?= session()->get('sent') ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <button type="submit" class="btn btn-primary">Verify</button>
                            </div>
                            <div class="col-12 col-sm-8 text-right">
                                <a href="/auth/send-otp">Not received?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>