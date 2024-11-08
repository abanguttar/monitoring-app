<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Monitoring App | Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
	<div class="container-fluid d-flex align-items-center" style="height: 100vh!important;">

		<div class="container">
			<div class="row">
				<div class="col-sm-6 offset-sm-3 ">
					<div class="card rounded-4">
						<h2 class="card-header">Monitoring App</h2>
						<div class="card-body">



							<form action="<?= url_to('login') ?>" method="post">
								<?= csrf_field() ?>


								<div class="form-group">
									<input type="text" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
										name="login" value="<?= set_value('login') ?>" placeholder="Username">
									<div class="invalid-feedback">
										<?= session('errors.login') ?>
									</div>
								</div>

								<div class="form-group mt-3">
									<input type="password" name="password" class="form-control  <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>">
									<div class="invalid-feedback">
										<?= session('errors.password') ?>
									</div>
								</div>

								<?php if ($config->allowRemembering): ?>
									<div class="form-check">
										<label class="form-check-label">
											<input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked <?php endif ?>>
											<?= lang('Auth.rememberMe') ?>
										</label>
									</div>
								<?php endif; ?>

								<br>

								<button type="submit" class="btn btn-danger btn-block"><?= lang('Auth.loginAction') ?></button>
							</form>

							<hr>


						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</body>

</html>