<?php
/**
 *
 * The framework's functions and definitions
 */

define( 'WOODMART_THEME_DIR', get_template_directory_uri() );
define( 'WOODMART_THEMEROOT', get_template_directory() );
define( 'WOODMART_IMAGES', WOODMART_THEME_DIR . '/images' );
define( 'WOODMART_SCRIPTS', WOODMART_THEME_DIR . '/js' );
define( 'WOODMART_STYLES', WOODMART_THEME_DIR . '/css' );
define( 'WOODMART_FRAMEWORK', '/inc' );
define( 'WOODMART_DUMMY', WOODMART_THEME_DIR . '/inc/dummy-content' );
define( 'WOODMART_CLASSES', WOODMART_THEMEROOT . '/inc/classes' );
define( 'WOODMART_CONFIGS', WOODMART_THEMEROOT . '/inc/configs' );
define( 'WOODMART_HEADER_BUILDER', WOODMART_THEME_DIR . '/inc/modules/header-builder' );
define( 'WOODMART_ASSETS', WOODMART_THEME_DIR . '/inc/admin/assets' );
define( 'WOODMART_ASSETS_IMAGES', WOODMART_ASSETS . '/images' );
define( 'WOODMART_API_URL', 'https://xtemos.com/wp-json/xts/v1/' );
define( 'WOODMART_DEMO_URL', 'https://woodmart.xtemos.com/' );
define( 'WOODMART_PLUGINS_URL', WOODMART_DEMO_URL . 'plugins/' );
define( 'WOODMART_DUMMY_URL', WOODMART_DEMO_URL . 'dummy-content-new/' );
define( 'WOODMART_TOOLTIP_URL', WOODMART_DEMO_URL . 'theme-settings-tooltips/' );
define( 'WOODMART_SLUG', 'woodmart' );
define( 'WOODMART_CORE_VERSION', '1.1.6' );
define( 'WOODMART_WPB_CSS_VERSION', '1.0.2' );

if ( ! function_exists( 'woodmart_load_classes' ) ) {
	/**
	 * Load theme PHP classes.
	 *
	 * @return void
	 */
	function woodmart_load_classes() {
		$classes = array(
			'class-singleton.php',
			'class-api.php',
			'class-config.php',
			'class-layout.php',
			'class-autoupdates.php',
			'class-activation.php',
			'class-notices.php',
			'class-theme.php',
			'class-registry.php',
		);

		foreach ( $classes as $class ) {
			require WOODMART_CLASSES . DIRECTORY_SEPARATOR . $class;
		}
	}
}

woodmart_load_classes();

new XTS\Theme();

define( 'WOODMART_VERSION', woodmart_get_theme_info( 'Version' ) );

update_option('woodmart_token','activated');
update_option('woodmart_is_activated',true);
update_option('woodmart_dev_domain',0);









// Квиз
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Подключение стилей/скриптов квиза
 */
add_action('wp_enqueue_scripts', function () {
	wp_register_style('print-quiz-form', false);
	wp_enqueue_style('print-quiz-form');

	$css = '
	.print-quiz {
		background: #ffffff;
		border-radius: 18px;
		box-shadow: 0 20px 60px rgba(17, 24, 39, 0.08);
		padding: 32px;
		max-width: 860px;
		margin: 0 auto;
		border: 1px solid #edf0f5;
	}

	.print-quiz__head {
		margin-bottom: 24px;
	}

	.print-quiz__title {
		margin: 0 0 10px;
		font-size: 36px;
		line-height: 1.1;
		font-weight: 700;
		color: #1f2937;
	}

	.print-quiz__subtitle {
		margin: 0;
		font-size: 17px;
		line-height: 1.5;
		color: #6b7280;
	}

	.print-quiz__progress {
		position: relative;
		height: 10px;
		background: #eef2f8;
		border-radius: 999px;
		overflow: hidden;
		margin: 24px 0 30px;
	}

	.print-quiz__progress-bar {
		height: 100%;
		width: 20%;
		background: linear-gradient(90deg, #1f4fbf 0%, #2f6df6 100%);
		border-radius: 999px;
		transition: width 0.25s ease;
	}

	.print-quiz__step-counter {
		font-size: 14px;
		font-weight: 600;
		color: #1f4fbf;
		margin-bottom: 18px;
	}

	.print-quiz__step {
		display: none;
		animation: printQuizFade .22s ease;
	}

	.print-quiz__step.is-active {
		display: block;
	}

	@keyframes printQuizFade {
		from {
			opacity: 0;
			transform: translateY(8px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}

	.print-quiz__question {
		margin: 0 0 20px;
		font-size: 28px;
		line-height: 1.2;
		font-weight: 700;
		color: #1f2937;
	}

	.print-quiz__grid {
		display: grid;
		grid-template-columns: repeat(2, minmax(0, 1fr));
		gap: 16px;
	}

	.print-quiz__option input {
		position: absolute;
		opacity: 0;
		pointer-events: none;
	}

	.print-quiz__option-label {
		display: flex;
		align-items: center;
		justify-content: space-between;
		min-height: 74px;
		padding: 18px 20px;
		border: 1px solid #dbe3f0;
		border-radius: 16px;
		background: #fff;
		cursor: pointer;
		font-size: 17px;
		font-weight: 600;
		color: #1f2937;
		transition: all .2s ease;
		box-shadow: 0 8px 24px rgba(17, 24, 39, 0.03);
	}

	.print-quiz__option-label:hover {
		border-color: #2f6df6;
		transform: translateY(-1px);
	}

	.print-quiz__option input:checked + .print-quiz__option-label {
		background: #f4f8ff;
		border-color: #2f6df6;
		color: #1f4fbf;
		box-shadow: 0 12px 30px rgba(47, 109, 246, 0.12);
	}

	.print-quiz__option-check {
		width: 22px;
		height: 22px;
		border-radius: 999px;
		border: 2px solid #c9d4e5;
		flex: 0 0 22px;
		position: relative;
		margin-left: 14px;
	}

	.print-quiz__option input:checked + .print-quiz__option-label .print-quiz__option-check {
		border-color: #2f6df6;
	}

	.print-quiz__option input:checked + .print-quiz__option-label .print-quiz__option-check::after {
		content: "";
		position: absolute;
		inset: 4px;
		border-radius: 999px;
		background: #2f6df6;
	}

	.print-quiz__fields {
		display: grid;
		grid-template-columns: repeat(2, minmax(0, 1fr));
		gap: 16px;
	}

	.print-quiz__field--full {
		grid-column: 1 / -1;
	}

	.print-quiz__field label {
		display: block;
		margin-bottom: 8px;
		font-size: 15px;
		font-weight: 600;
		color: #374151;
	}

	.print-quiz__field input,
	.print-quiz__field textarea {
		width: 100%;
		height: 56px;
		padding: 0 16px;
		border: 1px solid #dbe3f0;
		border-radius: 14px;
		background: #fff;
		font-size: 16px;
		color: #1f2937;
		box-sizing: border-box;
		outline: none;
		transition: border-color .2s ease, box-shadow .2s ease;
	}

	.print-quiz__field textarea {
		height: 120px;
		padding-top: 14px;
		padding-bottom: 14px;
		resize: vertical;
	}

	.print-quiz__field input:focus,
	.print-quiz__field textarea:focus {
		border-color: #2f6df6;
		box-shadow: 0 0 0 4px rgba(47, 109, 246, 0.10);
	}

	.print-quiz__actions {
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 14px;
		margin-top: 28px;
	}

	.print-quiz__btns {
		display: flex;
		gap: 12px;
		flex-wrap: wrap;
	}

	.print-quiz__btn {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-height: 54px;
		padding: 0 24px;
		border-radius: 14px;
		border: 0;
		cursor: pointer;
		font-size: 16px;
		font-weight: 700;
		text-decoration: none;
		transition: .2s ease;
	}

	.print-quiz__btn--prev {
		background: #eef2f8;
		color: #1f2937;
	}

	.print-quiz__btn--prev:hover {
		background: #e5ebf4;
	}

	.print-quiz__btn--next,
	.print-quiz__btn--submit {
		background: linear-gradient(135deg, #1f4fbf 0%, #2f6df6 100%);
		color: #fff;
		box-shadow: 0 16px 34px rgba(31, 79, 191, 0.18);
	}

	.print-quiz__btn--next:hover,
	.print-quiz__btn--submit:hover {
		transform: translateY(-1px);
		box-shadow: 0 20px 36px rgba(31, 79, 191, 0.24);
	}

	.print-quiz__hint {
		font-size: 14px;
		color: #6b7280;
	}

	.print-quiz__error {
		margin-top: 16px;
		font-size: 14px;
		font-weight: 600;
		color: #d93025;
		display: none;
	}

	.print-quiz__success {
		display: none;
		padding: 22px;
		border-radius: 16px;
		background: #effaf1;
		border: 1px solid #b8e3bf;
		font-size: 17px;
		font-weight: 600;
		color: #1f6a30;
	}

	.print-quiz.is-success .print-quiz__form-wrap {
		display: none;
	}

	.print-quiz.is-success .print-quiz__success {
		display: block;
	}

	@media (max-width: 767px) {
		.print-quiz {
			padding: 22px 16px;
			border-radius: 16px;
		}

		.print-quiz__title {
			font-size: 28px;
		}

		.print-quiz__question {
			font-size: 22px;
		}

		.print-quiz__grid,
		.print-quiz__fields {
			grid-template-columns: 1fr;
		}

		.print-quiz__actions {
			flex-direction: column;
			align-items: stretch;
		}

		.print-quiz__btns {
			width: 100%;
		}

		.print-quiz__btn {
			width: 100%;
		}
	}
	';
	wp_add_inline_style('print-quiz-form', $css);

	wp_register_script('print-quiz-form', false, ['jquery'], null, true);
	wp_enqueue_script('print-quiz-form');

	$ajax_url = admin_url('admin-ajax.php');
	$nonce    = wp_create_nonce('print_quiz_nonce');

	$js = "
	jQuery(function($){
		$('.js-print-quiz').each(function(){
			const \$quiz = $(this);
			const \$steps = \$quiz.find('.print-quiz__step');
			const total = \$steps.length;
			let current = 0;

			function updateQuiz() {
				\$steps.removeClass('is-active').eq(current).addClass('is-active');
				const percent = ((current + 1) / total) * 100;
				\$quiz.find('.print-quiz__progress-bar').css('width', percent + '%');
				\$quiz.find('.js-print-quiz-current').text(current + 1);
				\$quiz.find('.js-print-quiz-total').text(total);

				\$quiz.find('.js-print-quiz-prev').toggle(current > 0);
				\$quiz.find('.js-print-quiz-next').toggle(current < total - 1);
				\$quiz.find('.js-print-quiz-submit').toggle(current === total - 1);
				\$quiz.find('.print-quiz__error').hide().text('');
			}

			function validateStep(index) {
				const \$step = \$steps.eq(index);
				let valid = true;

				const \$requiredRadioGroups = \$step.find('[data-required-radio]');
				\$requiredRadioGroups.each(function(){
					const name = $(this).data('required-radio');
					if (!\$step.find('input[name=\"' + name + '\"]:checked').length) {
						valid = false;
					}
				});

				\$step.find('[data-required-field]').each(function(){
					if (!$(this).val().trim()) {
						valid = false;
					}
				});

				if (!valid) {
					\$quiz.find('.print-quiz__error').text('Пожалуйста, заполните обязательные поля этого шага.').show();
				}

				return valid;
			}

			\$quiz.on('click', '.js-print-quiz-next', function(e){
				e.preventDefault();
				if (!validateStep(current)) {
					return;
				}
				if (current < total - 1) {
					current++;
					updateQuiz();
				}
			});

			\$quiz.on('click', '.js-print-quiz-prev', function(e){
				e.preventDefault();
				if (current > 0) {
					current--;
					updateQuiz();
				}
			});

			\$quiz.on('submit', 'form', function(e){
				e.preventDefault();

				if (!validateStep(current)) {
					return;
				}

				const \$form = $(this);
				const formData = \$form.serializeArray();
				formData.push({ name: 'action', value: 'submit_print_quiz_form' });
				formData.push({ name: 'nonce', value: '{$nonce}' });

				const \$submit = \$quiz.find('.js-print-quiz-submit');
				const oldText = \$submit.text();

				\$submit.prop('disabled', true).text('Отправка...');

				$.post('{$ajax_url}', formData)
					.done(function(response){
						if (response && response.success) {
							\$quiz.addClass('is-success');
						} else {
							const msg = response && response.data ? response.data : 'Не удалось отправить форму. Попробуйте ещё раз.';
							\$quiz.find('.print-quiz__error').text(msg).show();
						}
					})
					.fail(function(){
						\$quiz.find('.print-quiz__error').text('Ошибка соединения. Попробуйте ещё раз.').show();
					})
					.always(function(){
						\$submit.prop('disabled', false).text(oldText);
					});
			});

			updateQuiz();
		});
	});
	";
	wp_add_inline_script('print-quiz-form', $js);
});


/**
 * Шорткод квиза
 */
add_shortcode('print_quiz_form', function () {
	ob_start(); ?>
	<div class="print-quiz js-print-quiz">
		<div class="print-quiz__success">
			Спасибо! Заявка отправлена. Мы свяжемся с вами в ближайшее время.
		</div>

		<div class="print-quiz__form-wrap">
			<div class="print-quiz__head">
				<h2 class="print-quiz__title">Рассчитайте стоимость печати</h2>
				<p class="print-quiz__subtitle">Ответьте на несколько вопросов, и мы подготовим расчёт по вашему заказу.</p>
			</div>

			<div class="print-quiz__step-counter">
				Шаг <span class="js-print-quiz-current">1</span> из <span class="js-print-quiz-total">5</span>
			</div>

			<div class="print-quiz__progress">
				<div class="print-quiz__progress-bar"></div>
			</div>

			<form>
				<div class="print-quiz__step is-active">
					<h3 class="print-quiz__question">Что хотите напечатать?</h3>
					<div class="print-quiz__grid" data-required-radio="product_type">
						<label class="print-quiz__option">
							<input type="radio" name="product_type" value="Визитки">
							<span class="print-quiz__option-label">Визитки <span class="print-quiz__option-check"></span></span>
						</label>
						<label class="print-quiz__option">
							<input type="radio" name="product_type" value="Флаеры">
							<span class="print-quiz__option-label">Флаеры <span class="print-quiz__option-check"></span></span>
						</label>
						<label class="print-quiz__option">
							<input type="radio" name="product_type" value="Буклеты">
							<span class="print-quiz__option-label">Буклеты <span class="print-quiz__option-check"></span></span>
						</label>
						<label class="print-quiz__option">
							<input type="radio" name="product_type" value="Дипломы">
							<span class="print-quiz__option-label">Дипломы <span class="print-quiz__option-check"></span></span>
						</label>
						<label class="print-quiz__option">
							<input type="radio" name="product_type" value="Наклейки">
							<span class="print-quiz__option-label">Наклейки <span class="print-quiz__option-check"></span></span>
						</label>
						<label class="print-quiz__option">
							<input type="radio" name="product_type" value="Индивидуальный заказ">
							<span class="print-quiz__option-label">Индивидуальный заказ <span class="print-quiz__option-check"></span></span>
						</label>
					</div>
				</div>

				<div class="print-quiz__step">
					<h3 class="print-quiz__question">Какой нужен тираж?</h3>
					<div class="print-quiz__grid" data-required-radio="quantity">
						<label class="print-quiz__option">
							<input type="radio" name="quantity" value="До 100 шт">
							<span class="print-quiz__option-label">До 100 шт <span class="print-quiz__option-check"></span></span>
						</label>
						<label class="print-quiz__option">
							<input type="radio" name="quantity" value="100–500 шт">
							<span class="print-quiz__option-label">100–500 шт <span class="print-quiz__option-check"></span></span>
						</label>
						<label class="print-quiz__option">
							<input type="radio" name="quantity" value="500–1000 шт">
							<span class="print-quiz__option-label">500–1000 шт <span class="print-quiz__option-check"></span></span>
						</label>
						<label class="print-quiz__option">
							<input type="radio" name="quantity" value="Более 1000 шт">
							<span class="print-quiz__option-label">Более 1000 шт <span class="print-quiz__option-check"></span></span>
						</label>
					</div>
				</div>

				<div class="print-quiz__step">
					<h3 class="print-quiz__question">Нужна ли помощь с дизайном?</h3>
					<div class="print-quiz__grid" data-required-radio="design_help">
						<label class="print-quiz__option">
							<input type="radio" name="design_help" value="Есть готовый макет">
							<span class="print-quiz__option-label">Есть готовый макет <span class="print-quiz__option-check"></span></span>
						</label>
						<label class="print-quiz__option">
							<input type="radio" name="design_help" value="Нужно немного доработать макет">
							<span class="print-quiz__option-label">Нужно доработать макет <span class="print-quiz__option-check"></span></span>
						</label>
						<label class="print-quiz__option">
							<input type="radio" name="design_help" value="Нужно сделать с нуля">
							<span class="print-quiz__option-label">Нужно сделать с нуля <span class="print-quiz__option-check"></span></span>
						</label>
						<label class="print-quiz__option">
							<input type="radio" name="design_help" value="Пока не знаю">
							<span class="print-quiz__option-label">Пока не знаю <span class="print-quiz__option-check"></span></span>
						</label>
					</div>
				</div>

				<div class="print-quiz__step">
					<h3 class="print-quiz__question">Когда нужен заказ?</h3>
					<div class="print-quiz__grid" data-required-radio="deadline">
						<label class="print-quiz__option">
							<input type="radio" name="deadline" value="Срочно">
							<span class="print-quiz__option-label">Срочно <span class="print-quiz__option-check"></span></span>
						</label>
						<label class="print-quiz__option">
							<input type="radio" name="deadline" value="1–3 дня">
							<span class="print-quiz__option-label">1–3 дня <span class="print-quiz__option-check"></span></span>
						</label>
						<label class="print-quiz__option">
							<input type="radio" name="deadline" value="На этой неделе">
							<span class="print-quiz__option-label">На этой неделе <span class="print-quiz__option-check"></span></span>
						</label>
						<label class="print-quiz__option">
							<input type="radio" name="deadline" value="Сроки не критичны">
							<span class="print-quiz__option-label">Сроки не критичны <span class="print-quiz__option-check"></span></span>
						</label>
					</div>
				</div>

				<div class="print-quiz__step">
					<h3 class="print-quiz__question">Оставьте контакты</h3>

					<div class="print-quiz__fields">
						<div class="print-quiz__field">
							<label for="print-quiz-name">Ваше имя</label>
							<input id="print-quiz-name" type="text" name="client_name" data-required-field>
						</div>

						<div class="print-quiz__field">
							<label for="print-quiz-phone">Телефон</label>
							<input id="print-quiz-phone" type="tel" name="client_phone" placeholder="+7 (___) ___-__-__" data-required-field>
						</div>

						<div class="print-quiz__field print-quiz__field--full">
							<label for="print-quiz-comment">Комментарий</label>
							<textarea id="print-quiz-comment" name="client_comment" placeholder="Например: формат, бумага, размеры, пожелания"></textarea>
						</div>
					</div>
				</div>

				<div class="print-quiz__actions">
					<div class="print-quiz__hint">Заполнение займёт меньше минуты</div>

					<div class="print-quiz__btns">
						<button type="button" class="print-quiz__btn print-quiz__btn--prev js-print-quiz-prev" style="display:none;">Назад</button>
						<button type="button" class="print-quiz__btn print-quiz__btn--next js-print-quiz-next">Далее</button>
						<button type="submit" class="print-quiz__btn print-quiz__btn--submit js-print-quiz-submit" style="display:none;">Отправить заявку</button>
					</div>
				</div>

				<div class="print-quiz__error"></div>
			</form>
		</div>
	</div>
	<?php
	return ob_get_clean();
});


/**
 * AJAX обработчик
 */
add_action('wp_ajax_submit_print_quiz_form', 'submit_print_quiz_form_callback');
add_action('wp_ajax_nopriv_submit_print_quiz_form', 'submit_print_quiz_form_callback');

function submit_print_quiz_form_callback() {
	if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'print_quiz_nonce')) {
		wp_send_json_error('Ошибка безопасности. Обновите страницу и попробуйте снова.');
	}

	$product_type = isset($_POST['product_type']) ? sanitize_text_field(wp_unslash($_POST['product_type'])) : '';
	$quantity     = isset($_POST['quantity']) ? sanitize_text_field(wp_unslash($_POST['quantity'])) : '';
	$design_help  = isset($_POST['design_help']) ? sanitize_text_field(wp_unslash($_POST['design_help'])) : '';
	$deadline     = isset($_POST['deadline']) ? sanitize_text_field(wp_unslash($_POST['deadline'])) : '';
	$name         = isset($_POST['client_name']) ? sanitize_text_field(wp_unslash($_POST['client_name'])) : '';
	$phone        = isset($_POST['client_phone']) ? sanitize_text_field(wp_unslash($_POST['client_phone'])) : '';
	$comment      = isset($_POST['client_comment']) ? sanitize_textarea_field(wp_unslash($_POST['client_comment'])) : '';

	if (!$product_type || !$quantity || !$design_help || !$deadline || !$name || !$phone) {
		wp_send_json_error('Пожалуйста, заполните все обязательные поля.');
	}

	$to      = get_option('admin_email');
	$subject = 'Новая заявка с квиза на печать';

	$message = "Новая заявка с сайта:\n\n";
	$message .= "Что нужно: {$product_type}\n";
	$message .= "Тираж: {$quantity}\n";
	$message .= "Дизайн: {$design_help}\n";
	$message .= "Сроки: {$deadline}\n";
	$message .= "Имя: {$name}\n";
	$message .= "Телефон: {$phone}\n";
	$message .= "Комментарий: {$comment}\n";

	$headers = ['Content-Type: text/plain; charset=UTF-8'];

	$sent = wp_mail($to, $subject, $message, $headers);

	if (!$sent) {
		wp_send_json_error('Форма не отправилась. Проверьте настройки почты на сайте.');
	}

	wp_send_json_success('ok');
}


















if (!defined('ABSPATH')) {
	exit;
}

/**
 * FAQ shortcode
 * Использование: [gl_faq]
 */
add_action('wp_enqueue_scripts', 'gl_faq_shortcode_assets');
function gl_faq_shortcode_assets() {
	wp_register_style('gl-faq-shortcode', false);

	$css = '
	.gl-faq {
		width: 100%;
		padding: 72px 0;
		background: linear-gradient(180deg, #f8fafc 0%, #f3f6fb 100%);
	}

	.gl-faq__inner {
		width: 100%;
		max-width: none;
		margin: 0;
		padding: 0 24px;
		box-sizing: border-box;
	}

	.gl-faq__head {
		width: 100%;
		max-width: none;
		margin: 0 0 32px;
		text-align: center;
	}

	.gl-faq__label {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-height: 32px;
		padding: 0 14px;
		border-radius: 999px;
		background: rgba(37, 80, 199, 0.08);
		color: #2550c7;
		font-size: 13px;
		font-weight: 700;
		letter-spacing: 0.04em;
		text-transform: uppercase;
		margin-bottom: 14px;
	}

	.gl-faq__title {
		margin: 0 0 12px;
		font-size: 42px;
		line-height: 1.08;
		font-weight: 700;
		color: #1f2937;
	}

	.gl-faq__subtitle {
		margin: 0;
		font-size: 18px;
		line-height: 1.6;
		color: #6b7280;
	}

	.gl-faq__list {
		display: grid;
		grid-template-columns: 1fr;
		gap: 14px;
		width: 100%;
		max-width: none;
		margin: 0;
	}

	.gl-faq__item {
		position: relative;
		width: 100%;
		background: #fff;
		border: 1px solid #e6ebf4;
		border-radius: 20px;
		box-shadow: 0 10px 30px rgba(17, 24, 39, 0.04);
		overflow: hidden;
		transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
		box-sizing: border-box;
	}

	.gl-faq__item:hover {
		transform: translateY(-2px);
		box-shadow: 0 18px 40px rgba(37, 80, 199, 0.08);
		border-color: #d5dff1;
	}

	.gl-faq__item.is-open {
		border-color: rgba(37, 80, 199, 0.24);
		box-shadow: 0 18px 42px rgba(37, 80, 199, 0.10);
	}

	.gl-faq__question {
		position: relative;
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 18px;
		width: 100%;
		padding: 24px 28px;
		border: 0;
		background: transparent;
		text-align: left;
		cursor: pointer;
		font-size: 22px;
		line-height: 1.35;
		font-weight: 600;
		color: #1f2937;
		transition: color 0.2s ease;
		box-sizing: border-box;
	}

	.gl-faq__question:hover {
		color: #2550c7;
	}

	.gl-faq__icon {
		position: relative;
		flex: 0 0 42px;
		width: 42px;
		height: 42px;
		border-radius: 999px;
		background: #f4f7fc;
		border: 1px solid #dfe7f4;
		transition: all 0.25s ease;
	}

	.gl-faq__icon::before,
	.gl-faq__icon::after {
		content: "";
		position: absolute;
		top: 50%;
		left: 50%;
		width: 16px;
		height: 2px;
		background: #2550c7;
		border-radius: 999px;
		transform: translate(-50%, -50%);
		transition: transform 0.25s ease, opacity 0.25s ease;
	}

	.gl-faq__icon::after {
		transform: translate(-50%, -50%) rotate(90deg);
	}

	.gl-faq__item.is-open .gl-faq__icon {
		background: #2550c7;
		border-color: #2550c7;
		box-shadow: 0 10px 24px rgba(37, 80, 199, 0.22);
	}

	.gl-faq__item.is-open .gl-faq__icon::before,
	.gl-faq__item.is-open .gl-faq__icon::after {
		background: #fff;
	}

	.gl-faq__item.is-open .gl-faq__icon::after {
		transform: translate(-50%, -50%) rotate(0deg);
		opacity: 0;
	}

	.gl-faq__answer {
		display: grid;
		grid-template-rows: 0fr;
		transition: grid-template-rows 0.35s ease;
	}

	.gl-faq__item.is-open .gl-faq__answer {
		grid-template-rows: 1fr;
	}

	.gl-faq__answer-inner {
		overflow: hidden;
		padding: 0 28px;
		font-size: 17px;
		line-height: 1.7;
		color: #5b6472;
		box-sizing: border-box;
	}

	.gl-faq__item.is-open .gl-faq__answer-inner {
		padding-bottom: 26px;
	}

	.gl-faq__answer-inner p {
		margin: 0;
	}

	@media (max-width: 991px) {
		.gl-faq {
			padding: 56px 0;
		}

		.gl-faq__inner {
			padding: 0 20px;
		}

		.gl-faq__title {
			font-size: 34px;
		}

		.gl-faq__subtitle {
			font-size: 16px;
		}

		.gl-faq__question {
			padding: 20px 22px;
			font-size: 19px;
		}

		.gl-faq__answer-inner {
			padding: 0 22px;
			font-size: 15px;
		}

		.gl-faq__item.is-open .gl-faq__answer-inner {
			padding-bottom: 22px;
		}
	}

	@media (max-width: 767px) {
		.gl-faq {
			padding: 44px 0;
		}

		.gl-faq__inner {
			padding: 0 14px;
		}

		.gl-faq__head {
			margin-bottom: 24px;
		}

		.gl-faq__title {
			font-size: 28px;
		}

		.gl-faq__question {
			padding: 18px;
			font-size: 17px;
			gap: 14px;
		}

		.gl-faq__icon {
			flex: 0 0 36px;
			width: 36px;
			height: 36px;
		}

		.gl-faq__answer-inner {
			padding: 0 18px;
			font-size: 14px;
			line-height: 1.65;
		}

		.gl-faq__item.is-open .gl-faq__answer-inner {
			padding-bottom: 18px;
		}
	}
';

	wp_enqueue_style('gl-faq-shortcode');
	wp_add_inline_style('gl-faq-shortcode', $css);

	wp_register_script('gl-faq-shortcode', false, array(), null, true);

	$js = '
	document.addEventListener("DOMContentLoaded", function () {
		document.querySelectorAll("[data-gl-faq]").forEach(function(faq) {
			const items = faq.querySelectorAll(".gl-faq__item");

			items.forEach(function(item) {
				const button = item.querySelector(".gl-faq__question");

				if (!button) return;

				button.addEventListener("click", function() {
					const isOpen = item.classList.contains("is-open");

					items.forEach(function(otherItem) {
						otherItem.classList.remove("is-open");
					});

					if (!isOpen) {
						item.classList.add("is-open");
					}
				});
			});
		});
	});
	';

	wp_enqueue_script('gl-faq-shortcode');
	wp_add_inline_script('gl-faq-shortcode', $js);
}

add_shortcode('gl_faq', 'gl_faq_shortcode_render');
function gl_faq_shortcode_render($atts = array(), $content = null) {
	ob_start();
	?>
	<section class="gl-faq">
		<div class="gl-faq__inner">
			<div class="gl-faq__head">
				<span class="gl-faq__label">FAQ</span>
				<h2 class="gl-faq__title">Частые вопросы</h2>
				<p class="gl-faq__subtitle">
					Ответы на популярные вопросы по заказу печати, срокам, макетам и доставке.
				</p>
			</div>

			<div class="gl-faq__list" data-gl-faq>
				<div class="gl-faq__item is-open">
					<button class="gl-faq__question" type="button">
						<span>Как быстро вы рассчитываете стоимость заказа?</span>
						<span class="gl-faq__icon"></span>
					</button>
					<div class="gl-faq__answer">
						<div class="gl-faq__answer-inner">
							<p>Обычно расчет подготавливаем в ближайшее рабочее время. По стандартным заказам можем ответить быстро, по нестандартным — после уточнения деталей.</p>
						</div>
					</div>
				</div>

				<div class="gl-faq__item">
					<button class="gl-faq__question" type="button">
						<span>Можно ли заказать печать без готового макета?</span>
						<span class="gl-faq__icon"></span>
					</button>
					<div class="gl-faq__answer">
						<div class="gl-faq__answer-inner">
							<p>Да, можно. Если у вас нет готового макета, мы можем обсудить подготовку дизайна или доработку существующих материалов под печать.</p>
						</div>
					</div>
				</div>

				<div class="gl-faq__item">
					<button class="gl-faq__question" type="button">
						<span>Какие сроки изготовления?</span>
						<span class="gl-faq__icon"></span>
					</button>
					<div class="gl-faq__answer">
						<div class="gl-faq__answer-inner">
							<p>Сроки зависят от типа продукции, тиража и загрузки. Срочные заказы обсуждаются отдельно. Точные сроки сообщаем после расчета.</p>
						</div>
					</div>
				</div>

				<div class="gl-faq__item">
					<button class="gl-faq__question" type="button">
						<span>Работаете ли вы с малыми тиражами?</span>
						<span class="gl-faq__icon"></span>
					</button>
					<div class="gl-faq__answer">
						<div class="gl-faq__answer-inner">
							<p>Да, работаем как с небольшими, так и с крупными тиражами. Всё зависит от конкретного вида продукции и технических требований.</p>
						</div>
					</div>
				</div>

				<div class="gl-faq__item">
					<button class="gl-faq__question" type="button">
						<span>Есть ли доставка?</span>
						<span class="gl-faq__icon"></span>
					</button>
					<div class="gl-faq__answer">
						<div class="gl-faq__answer-inner">
							<p>Да, возможна доставка по Москве и в другие регионы. Способ и стоимость доставки уточняются при оформлении заказа.</p>
						</div>
					</div>
				</div>

				<div class="gl-faq__item">
					<button class="gl-faq__question" type="button">
						<span>Проверяете ли вы макеты перед печатью?</span>
						<span class="gl-faq__icon"></span>
					</button>
					<div class="gl-faq__answer">
						<div class="gl-faq__answer-inner">
							<p>Да, перед запуском в печать мы проверяем макет на базовые технические параметры. Если есть критичные моменты, сообщаем об этом заранее.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
















if (!defined('ABSPATH')) {
	exit;
}

/**
 * How to order shortcode
 * Использование: [gl_how_order]
 */
add_action('wp_enqueue_scripts', 'gl_how_order_shortcode_assets');
function gl_how_order_shortcode_assets() {
	wp_register_style('gl-how-order-shortcode', false);

	$css = '
	.gl-how-order {
		width: 100%;
		padding: 72px 0;
		background: linear-gradient(180deg, #ffffff 0%, #f7faff 100%);
	}

	.gl-how-order__inner {
		width: 100%;
		max-width: none;
		margin: 0;
		padding: 0 24px;
		box-sizing: border-box;
	}

	.gl-how-order__head {
		width: 100%;
		max-width: 860px;
		margin: 0 0 36px;
		text-align: left;
	}

	.gl-how-order__label {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-height: 32px;
		padding: 0 14px;
		margin-bottom: 14px;
		border-radius: 999px;
		background: rgba(37, 80, 199, 0.08);
		color: #2550c7;
		font-size: 13px;
		font-weight: 700;
		letter-spacing: 0.04em;
		text-transform: uppercase;
	}

	.gl-how-order__title {
		margin: 0 0 12px;
		font-size: 42px;
		line-height: 1.08;
		font-weight: 700;
		color: #1f2937;
	}

	.gl-how-order__subtitle {
		margin: 0;
		font-size: 18px;
		line-height: 1.6;
		color: #6b7280;
	}

	.gl-how-order__grid {
		display: grid;
		grid-template-columns: repeat(5, minmax(0, 1fr));
		gap: 18px;
		width: 100%;
	}

	.gl-how-order__item {
		position: relative;
		background: #fff;
		border: 1px solid #e6ebf4;
		border-radius: 22px;
		padding: 28px 24px 24px;
		box-shadow: 0 10px 30px rgba(17, 24, 39, 0.04);
		transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
		overflow: hidden;
	}

	.gl-how-order__item:hover {
		transform: translateY(-4px);
		border-color: #cfdcf5;
		box-shadow: 0 22px 48px rgba(37, 80, 199, 0.10);
	}

	.gl-how-order__item::before {
		content: "";
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 4px;
		background: linear-gradient(90deg, #2550c7 0%, #4d7cff 100%);
		opacity: 0;
		transition: opacity 0.22s ease;
	}

	.gl-how-order__item:hover::before {
		opacity: 1;
	}

	.gl-how-order__step {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 52px;
		height: 52px;
		margin-bottom: 18px;
		border-radius: 16px;
		background: linear-gradient(135deg, #2550c7 0%, #4d7cff 100%);
		box-shadow: 0 14px 28px rgba(37, 80, 199, 0.22);
		color: #fff;
		font-size: 20px;
		font-weight: 700;
		line-height: 1;
	}

	.gl-how-order__item-title {
		margin: 0 0 10px;
		font-size: 22px;
		line-height: 1.25;
		font-weight: 700;
		color: #1f2937;
	}

	.gl-how-order__item-text {
		margin: 0;
		font-size: 16px;
		line-height: 1.7;
		color: #5b6472;
	}

	.gl-how-order__bottom {
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 24px;
		margin-top: 28px;
		padding: 24px 28px;
		border: 1px solid #e6ebf4;
		border-radius: 22px;
		background: #fff;
		box-shadow: 0 10px 30px rgba(17, 24, 39, 0.04);
	}

	.gl-how-order__bottom-text {
		margin: 0;
		font-size: 17px;
		line-height: 1.65;
		color: #4b5563;
	}

	.gl-how-order__btn {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		flex-shrink: 0;
		min-height: 54px;
		padding: 0 24px;
		border-radius: 14px;
		background: linear-gradient(135deg, #2550c7 0%, #4d7cff 100%);
		color: #fff;
		font-size: 16px;
		font-weight: 700;
		text-decoration: none;
		box-shadow: 0 16px 34px rgba(37, 80, 199, 0.18);
		transition: transform 0.22s ease, box-shadow 0.22s ease;
	}

	.gl-how-order__btn:hover {
		color: #fff;
		transform: translateY(-2px);
		box-shadow: 0 20px 40px rgba(37, 80, 199, 0.24);
	}

	@media (max-width: 1299px) {
		.gl-how-order__grid {
			grid-template-columns: repeat(3, minmax(0, 1fr));
		}
	}

	@media (max-width: 991px) {
		.gl-how-order {
			padding: 56px 0;
		}

		.gl-how-order__inner {
			padding: 0 20px;
		}

		.gl-how-order__title {
			font-size: 34px;
		}

		.gl-how-order__subtitle {
			font-size: 16px;
		}

		.gl-how-order__grid {
			grid-template-columns: repeat(2, minmax(0, 1fr));
		}

		.gl-how-order__bottom {
			flex-direction: column;
			align-items: flex-start;
		}
	}

	@media (max-width: 767px) {
		.gl-how-order {
			padding: 44px 0;
		}

		.gl-how-order__inner {
			padding: 0 14px;
		}

		.gl-how-order__head {
			margin-bottom: 24px;
		}

		.gl-how-order__title {
			font-size: 28px;
		}

		.gl-how-order__grid {
			grid-template-columns: 1fr;
			gap: 14px;
		}

		.gl-how-order__item {
			padding: 22px 18px 18px;
			border-radius: 18px;
		}

		.gl-how-order__step {
			width: 46px;
			height: 46px;
			margin-bottom: 14px;
			font-size: 18px;
			border-radius: 14px;
		}

		.gl-how-order__item-title {
			font-size: 19px;
		}

		.gl-how-order__item-text {
			font-size: 15px;
			line-height: 1.65;
		}

		.gl-how-order__bottom {
			margin-top: 20px;
			padding: 18px;
			border-radius: 18px;
		}

		.gl-how-order__bottom-text {
			font-size: 15px;
			line-height: 1.6;
		}

		.gl-how-order__btn {
			width: 100%;
		}
	}
	';

	wp_enqueue_style('gl-how-order-shortcode');
	wp_add_inline_style('gl-how-order-shortcode', $css);
}

add_shortcode('gl_how_order', 'gl_how_order_shortcode_render');
function gl_how_order_shortcode_render($atts = array(), $content = null) {
	$atts = shortcode_atts(array(
		'button_text' => 'Оставить заявку',
		'button_url'  => '#quiz',
	), $atts, 'gl_how_order');

	ob_start();
	?>
	<section class="gl-how-order">
		<div class="gl-how-order__inner">
			<div class="gl-how-order__head">
				<span class="gl-how-order__label">Как это работает</span>
				<h2 class="gl-how-order__title">Как оформить заказ</h2>
				<p class="gl-how-order__subtitle">
					Мы сделали процесс заказа простым и понятным: от выбора продукции до отправки готового тиража.
				</p>
			</div>

			<div class="gl-how-order__grid">
				<div class="gl-how-order__item">
					<div class="gl-how-order__step">1</div>
					<h3 class="gl-how-order__item-title">Выберите продукцию</h3>
					<p class="gl-how-order__item-text">
						Перейдите в нужную категорию и выберите тип печатной продукции: визитки, флаеры, буклеты, дипломы или наклейки.
					</p>
				</div>

				<div class="gl-how-order__item">
					<div class="gl-how-order__step">2</div>
					<h3 class="gl-how-order__item-title">Укажите параметры</h3>
					<p class="gl-how-order__item-text">
						Выберите формат, тираж, материалы, дополнительные опции и пожелания по изготовлению заказа.
					</p>
				</div>

				<div class="gl-how-order__item">
					<div class="gl-how-order__step">3</div>
					<h3 class="gl-how-order__item-title">Загрузите макет</h3>
					<p class="gl-how-order__item-text">
						Прикрепите готовый файл или оставьте комментарий, если нужен дизайн, доработка макета или помощь с подготовкой.
					</p>
				</div>

				<div class="gl-how-order__item">
					<div class="gl-how-order__step">4</div>
					<h3 class="gl-how-order__item-title">Подтвердите заказ</h3>
					<p class="gl-how-order__item-text">
						Мы проверим данные, уточним детали, подтвердим стоимость и согласуем сроки изготовления перед запуском.
					</p>
				</div>

				<div class="gl-how-order__item">
					<div class="gl-how-order__step">5</div>
					<h3 class="gl-how-order__item-title">Получите готовый тираж</h3>
					<p class="gl-how-order__item-text">
						После печати вы сможете забрать заказ самовывозом или оформить доставку по Москве и в другие регионы.
					</p>
				</div>
			</div>

			<div class="gl-how-order__bottom">
				<p class="gl-how-order__bottom-text">
					Не уверены, какой вариант подойдет лучше? Оставьте заявку, и мы поможем подобрать формат, материалы и оптимальный тираж под вашу задачу.
				</p>

				<a class="gl-how-order__btn" href="<?php echo esc_url($atts['button_url']); ?>">
					<?php echo esc_html($atts['button_text']); ?>
				</a>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}














if (!defined('ABSPATH')) {
	exit;
}

/**
 * Advantages shortcode
 * Использование: [gl_advantages]
 */
add_action('wp_enqueue_scripts', 'gl_advantages_shortcode_assets');
function gl_advantages_shortcode_assets() {
	wp_register_style('gl-advantages-shortcode', false);

	$css = '
	.gl-advantages {
		width: 100%;
		padding: 72px 0;
		background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
	}

	.gl-advantages__inner {
		width: 100%;
		max-width: none;
		margin: 0;
		padding: 0 24px;
		box-sizing: border-box;
	}

	.gl-advantages__head {
		width: 100%;
		max-width: 860px;
		margin: 0 0 36px;
		text-align: left;
	}

	.gl-advantages__label {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-height: 32px;
		padding: 0 14px;
		margin-bottom: 14px;
		border-radius: 999px;
		background: rgba(37, 80, 199, 0.08);
		color: #2550c7;
		font-size: 13px;
		font-weight: 700;
		letter-spacing: 0.04em;
		text-transform: uppercase;
	}

	.gl-advantages__title {
		margin: 0 0 12px;
		font-size: 42px;
		line-height: 1.08;
		font-weight: 700;
		color: #1f2937;
	}

	.gl-advantages__subtitle {
		margin: 0;
		font-size: 18px;
		line-height: 1.6;
		color: #6b7280;
	}

	.gl-advantages__grid {
		display: grid;
		grid-template-columns: repeat(4, minmax(0, 1fr));
		gap: 18px;
		width: 100%;
	}

	.gl-advantages__item {
		position: relative;
		display: flex;
		flex-direction: column;
		height: 100%;
		padding: 28px 24px 24px;
		background: #fff;
		border: 1px solid #e6ebf4;
		border-radius: 22px;
		box-shadow: 0 10px 30px rgba(17, 24, 39, 0.04);
		overflow: hidden;
		transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
		box-sizing: border-box;
	}

	.gl-advantages__item:hover {
		transform: translateY(-4px);
		border-color: #cfdcf5;
		box-shadow: 0 22px 48px rgba(37, 80, 199, 0.10);
	}

	.gl-advantages__item::before {
		content: "";
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 4px;
		background: linear-gradient(90deg, #2550c7 0%, #4d7cff 100%);
		opacity: 0;
		transition: opacity 0.22s ease;
	}

	.gl-advantages__item:hover::before {
		opacity: 1;
	}

	.gl-advantages__icon {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 58px;
		height: 58px;
		margin-bottom: 18px;
		border-radius: 18px;
		background: linear-gradient(135deg, #2550c7 0%, #4d7cff 100%);
		box-shadow: 0 14px 28px rgba(37, 80, 199, 0.22);
		color: #fff;
	}

	.gl-advantages__icon svg {
		width: 28px;
		height: 28px;
		display: block;
		fill: currentColor;
	}

	.gl-advantages__item-title {
		margin: 0 0 10px;
		font-size: 22px;
		line-height: 1.25;
		font-weight: 700;
		color: #1f2937;
	}

	.gl-advantages__item-text {
		margin: 0;
		font-size: 16px;
		line-height: 1.7;
		color: #5b6472;
	}

	@media (max-width: 1299px) {
		.gl-advantages__grid {
			grid-template-columns: repeat(2, minmax(0, 1fr));
		}
	}

	@media (max-width: 991px) {
		.gl-advantages {
			padding: 56px 0;
		}

		.gl-advantages__inner {
			padding: 0 20px;
		}

		.gl-advantages__title {
			font-size: 34px;
		}

		.gl-advantages__subtitle {
			font-size: 16px;
		}
	}

	@media (max-width: 767px) {
		.gl-advantages {
			padding: 44px 0;
		}

		.gl-advantages__inner {
			padding: 0 14px;
		}

		.gl-advantages__head {
			margin-bottom: 24px;
		}

		.gl-advantages__title {
			font-size: 28px;
		}

		.gl-advantages__grid {
			grid-template-columns: 1fr;
			gap: 14px;
		}

		.gl-advantages__item {
			padding: 22px 18px 18px;
			border-radius: 18px;
		}

		.gl-advantages__icon {
			width: 50px;
			height: 50px;
			margin-bottom: 14px;
			border-radius: 14px;
		}

		.gl-advantages__icon svg {
			width: 24px;
			height: 24px;
		}

		.gl-advantages__item-title {
			font-size: 19px;
		}

		.gl-advantages__item-text {
			font-size: 15px;
			line-height: 1.65;
		}
	}
	';

	wp_enqueue_style('gl-advantages-shortcode');
	wp_add_inline_style('gl-advantages-shortcode', $css);
}

add_shortcode('gl_advantages', 'gl_advantages_shortcode_render');
function gl_advantages_shortcode_render($atts = array(), $content = null) {
	ob_start();
	?>
	<section class="gl-advantages">
		<div class="gl-advantages__inner">
			<div class="gl-advantages__head">
				<span class="gl-advantages__label">Преимущества</span>
				<h2 class="gl-advantages__title">Почему выбирают нас</h2>
				<p class="gl-advantages__subtitle">
					Помогаем быстро оформить заказ, проверить макет и получить качественную печать без лишних сложностей.
				</p>
			</div>

			<div class="gl-advantages__grid">
				<div class="gl-advantages__item">
					<div class="gl-advantages__icon" aria-hidden="true">
						<svg viewBox="0 0 24 24"><path d="M12 2a1 1 0 0 1 1 1v1.07A8.003 8.003 0 0 1 20 12a8 8 0 1 1-9-7.93V3a1 1 0 0 1 1-1Zm1 5h-2v5.414l3.293 3.293 1.414-1.414L13 11.586V7Z"/></svg>
					</div>
					<h3 class="gl-advantages__item-title">Быстрый расчет</h3>
					<p class="gl-advantages__item-text">
						Оперативно рассчитываем стоимость заказа и подбираем оптимальный вариант под ваш тираж и задачу.
					</p>
				</div>

				<div class="gl-advantages__item">
					<div class="gl-advantages__icon" aria-hidden="true">
						<svg viewBox="0 0 24 24"><path d="M12 2 4 5v6c0 5.25 3.438 10.125 8 11 4.562-.875 8-5.75 8-11V5l-8-3Zm3.707 7.707-4.5 4.5a1 1 0 0 1-1.414 0l-2-2 1.414-1.414 1.293 1.293 3.793-3.793 1.414 1.414Z"/></svg>
					</div>
					<h3 class="gl-advantages__item-title">Проверка макета</h3>
					<p class="gl-advantages__item-text">
						Перед печатью проверяем базовые технические параметры макета и сообщаем, если нужно что-то исправить.
					</p>
				</div>

				<div class="gl-advantages__item">
					<div class="gl-advantages__icon" aria-hidden="true">
						<svg viewBox="0 0 24 24"><path d="M3 6a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v2h1.382a2 2 0 0 1 1.789 1.106l1.447 2.894c.138.276.211.58.211.889V17a2 2 0 0 1-2 2H20a3 3 0 1 1-6 0H10a3 3 0 1 1-6 0H3V6Zm2 0v8h1a3 3 0 0 1 6 0h2V6H5Zm14 4h-1v4h3.382l-1-2H19v-2Zm-12 8a1 1 0 1 0 0 2 1 1 0 0 0 0-2Zm10 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2Z"/></svg>
					</div>
					<h3 class="gl-advantages__item-title">Доставка по России</h3>
					<p class="gl-advantages__item-text">
						Отправляем готовую продукцию по Москве и в другие регионы удобным способом после изготовления.
					</p>
				</div>

				<div class="gl-advantages__item">
					<div class="gl-advantages__icon" aria-hidden="true">
						<svg viewBox="0 0 24 24"><path d="M4 4h16a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-5.586l-2.707 2.707a1 1 0 0 1-1.414 0L7.586 17H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Zm2 5v2h12V9H6Zm0-3v2h8V6H6Zm0 6v2h7v-2H6Z"/></svg>
					</div>
					<h3 class="gl-advantages__item-title">Помощь с заказом</h3>
					<p class="gl-advantages__item-text">
						Подскажем по материалам, форматам, тиражу и срокам, чтобы вы выбрали подходящее решение без лишних затрат.
					</p>
				</div>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}







add_filter('gettext_woodmart', function($translated, $text, $domain) {
	if ($text === 'Search for products') {
		return 'Поиск товаров';
	}

	return $translated;
}, 20, 3);





add_action('wp_head', function () {
    ?>
    <style>
        .woodmart-promo-popup,
        .wd-popup,
        .wd-popup-wrapper,
        .wd-age-verify,
        .wd-cookies-popup,
        .mfp-wrap,
        .mfp-bg {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }
    </style>
    <?php
}, 999);
/**
 * Динамический расчет стоимости печатной продукции через n8n.
 */
if (!defined('MYPRINTLAB_PRINT_PRICE_WEBHOOK_URL')) {
	define('MYPRINTLAB_PRINT_PRICE_WEBHOOK_URL', 'https://n8n.denkolapi.ru/webhook/817978ff-18b5-45d2-a6ba-a1a436e39c6e');
}

add_action('wp_enqueue_scripts', function () {
	if (!function_exists('is_product') || !is_product()) {
		return;
	}

	wp_register_script('myprintlab-print-price-calculator', false, array('jquery'), null, true);
	wp_enqueue_script('myprintlab-print-price-calculator');

	wp_localize_script('myprintlab-print-price-calculator', 'myprintlabPrintPrice', array(
		'ajaxUrl' => admin_url('admin-ajax.php'),
		'nonce'   => wp_create_nonce('myprintlab_print_price'),
	));

	$script = <<<'JS'
(function ($) {
	'use strict';

	var requestTimer = null;
	var activeRequest = null;
	var lastPayloadHash = '';
	var priceSelector = '.summary .price, .product-image-summary-wrap .price, .wd-single-price .price, .woocommerce-variation-price .price';

	function getProductForm($changedElement) {
		var $form = $changedElement.closest('form.cart, form.variations_form, form');

		if (!$form.length) {
			$form = $('form.cart, form.variations_form').first();
		}

		return $form;
	}

	function collectFormData($form) {
		var values = {};

		$form.find('input, select, textarea').each(function () {
			var field = this;
			var $field = $(field);
			var name = $field.attr('name');

			if (!name || field.disabled || name === 'add-to-cart') {
				return;
			}

			if ((field.type === 'checkbox' || field.type === 'radio') && !field.checked) {
				return;
			}

			if (name.indexOf('[]') !== -1) {
				name = name.replace('[]', '');
				if (!Array.isArray(values[name])) {
					values[name] = [];
				}
				values[name].push($field.val());
				return;
			}

			values[name] = $field.val();
		});

		var bodyPostId = $('body').attr('class').match(/postid-(\d+)/);
		values.product_id = values.product_id || $form.find('[name="add-to-cart"]').val() || (bodyPostId ? bodyPostId[1] : '') || '';
		values.quantity = values.quantity || $form.find('[name="quantity"]').val() || 1;
		values.page_url = window.location.href;

		return values;
	}

	function setLoading($form, isLoading) {
		$form.toggleClass('myprintlab-price-is-loading', isLoading);
		$(priceSelector).first().toggleClass('myprintlab-price-is-loading', isLoading);
	}

	function getPriceElement() {
		var $price = $(priceSelector).filter(':visible').first();

		if (!$price.length) {
			$price = $(priceSelector).first();
		}

		return $price;
	}

	function showPriceMessage(message, isError) {
		var $price = getPriceElement();

		if (!$price.length) {
			return;
		}

		var $message = $('.myprintlab-price-message');

		if (!$message.length) {
			$message = $('<div class="myprintlab-price-message" aria-live="polite"></div>');
			$price.after($message);
		}

		$message
			.toggleClass('myprintlab-price-message--error', !!isError)
			.text(message || '')
			.toggle(!!message);
	}

	function renderPrice(response) {
		if (!response || !response.success || !response.data || !response.data.price_html) {
			var message = response && response.data && response.data.message ? response.data.message : 'Не удалось получить актуальную стоимость.';
			showPriceMessage(message, true);
			return;
		}

		var $price = getPriceElement();

		if (!$price.length) {
			return;
		}

		$price.html(response.data.price_html);
		showPriceMessage('', false);
	}

	function requestPrice($form) {
		var payload = collectFormData($form);
		var payloadHash = JSON.stringify(payload);

		if (payloadHash === lastPayloadHash) {
			return;
		}

		lastPayloadHash = payloadHash;

		if (activeRequest) {
			activeRequest.abort();
		}

		setLoading($form, true);

		activeRequest = $.ajax({
			url: myprintlabPrintPrice.ajaxUrl,
			method: 'POST',
			dataType: 'json',
			data: {
				action: 'myprintlab_calculate_print_price',
				nonce: myprintlabPrintPrice.nonce,
				payload: JSON.stringify(payload)
			}
		}).done(renderPrice).fail(function (xhr) {
			lastPayloadHash = '';
			var message = xhr && xhr.responseJSON && xhr.responseJSON.data && xhr.responseJSON.data.message ? xhr.responseJSON.data.message : 'Не удалось получить актуальную стоимость.';
			showPriceMessage(message, true);
		}).always(function () {
			activeRequest = null;
			setLoading($form, false);
		});
	}

	function schedulePriceRequest(event) {
		var $form = getProductForm($(event.target));

		if (!$form.length) {
			return;
		}

		window.clearTimeout(requestTimer);
		requestTimer = window.setTimeout(function () {
			requestPrice($form);
		}, 350);
	}

	$(document).on('change input', 'form.cart input, form.cart select, form.cart textarea, form.variations_form input, form.variations_form select, form.variations_form textarea', schedulePriceRequest);
	$(document).on('found_variation reset_data woocommerce_variation_has_changed', 'form.variations_form', schedulePriceRequest);

	// Не дергаем webhook сразу при загрузке карточки: на первом рендере
	// параметры могут быть еще не выбраны, а n8n в таком случае возвращает 500.
	// Расчет запускается только после изменения пользователем полей товара
	// или события WooCommerce о подобранной вариации.
})(jQuery);
JS;

	wp_add_inline_script('myprintlab-print-price-calculator', $script);

	wp_register_style('myprintlab-print-price-calculator', false);
	wp_enqueue_style('myprintlab-print-price-calculator');
	wp_add_inline_style('myprintlab-print-price-calculator', '.myprintlab-price-is-loading{opacity:.55;position:relative}.myprintlab-price-is-loading:after{content:"Расчет...";display:inline-block;margin-left:8px;font-size:13px;color:#6b7280}.myprintlab-price-message{display:none;margin-top:8px;font-size:13px;line-height:1.4;color:#6b7280}.myprintlab-price-message--error{color:#b42318}');
});

add_action('wp_ajax_myprintlab_calculate_print_price', 'myprintlab_calculate_print_price');
add_action('wp_ajax_nopriv_myprintlab_calculate_print_price', 'myprintlab_calculate_print_price');

function myprintlab_calculate_print_price() {
	check_ajax_referer('myprintlab_print_price', 'nonce');

	$payload = isset($_POST['payload']) ? wp_unslash($_POST['payload']) : '';
	$data = json_decode($payload, true);

	if (!is_array($data)) {
		wp_send_json_error(array('message' => 'Некорректные параметры расчета.'), 400);
	}

	$webhook_url = apply_filters('myprintlab_print_price_webhook_url', MYPRINTLAB_PRINT_PRICE_WEBHOOK_URL, $data);

	if (empty($webhook_url) || !wp_http_validate_url($webhook_url)) {
		wp_send_json_error(array('message' => 'Некорректный URL webhook для расчета стоимости.'), 500);
	}

	$response = wp_remote_post($webhook_url, array(
		'timeout' => 12,
		'headers' => array(
			'Content-Type' => 'application/json; charset=utf-8',
		),
		'body' => wp_json_encode(array(
			'source' => 'woocommerce_product_page',
			'payload' => $data,
		)),
	));

	if (is_wp_error($response)) {
		wp_send_json_error(array('message' => $response->get_error_message()), 502);
	}

	$status_code = wp_remote_retrieve_response_code($response);
	$body = wp_remote_retrieve_body($response);

	if (200 > $status_code || 300 <= $status_code) {
		wp_send_json_error(array(
			'message' => sprintf('Webhook вернул HTTP %d. Проверьте сценарий расчета.', $status_code),
			'raw' => $body,
		), 502);
	}

	$decoded = json_decode($body, true);
	$result = myprintlab_extract_price_from_webhook_response(null === $decoded ? $body : $decoded);

	if (!empty($result['error'])) {
		wp_send_json_error(array(
			'message' => $result['error'],
			'raw' => $decoded ?: $body,
		), 502);
	}

	if (!empty($result['price_html'])) {
		wp_send_json_success(array(
			'price' => $result['price'],
			'price_html' => wp_kses_post($result['price_html']),
			'raw' => $decoded ?: $body,
		));
	}

	$price = $result['price'];

	if (null === $price || '' === $price) {
		wp_send_json_error(array(
			'message' => 'Webhook не вернул цену. Ожидаются поля price_html, price, total или amount.',
			'raw' => $decoded ?: $body,
		), 502);
	}

	$numeric_price = is_string($price) ? preg_replace('/[^0-9,.]/', '', $price) : $price;
	$numeric_price = is_string($numeric_price) ? str_replace(',', '.', $numeric_price) : $numeric_price;
	$price_html = function_exists('wc_price') && is_numeric($numeric_price) ? wc_price((float) $numeric_price) : esc_html((string) $price);

	wp_send_json_success(array(
		'price' => $price,
		'price_html' => $price_html,
		'raw' => $decoded ?: $body,
	));
}

function myprintlab_extract_price_from_webhook_response($response) {
	if (is_string($response)) {
		$trimmed = trim($response);

		if ('' === $trimmed) {
			return array(
				'price' => null,
				'price_html' => '',
				'error' => 'Webhook вернул пустой ответ.',
			);
		}

		if (is_numeric($trimmed)) {
			return array(
				'price' => $trimmed,
				'price_html' => '',
				'error' => '',
			);
		}

		return array(
			'price' => null,
			'price_html' => '',
			'error' => $trimmed,
		);
	}

	if (!is_array($response)) {
		return array(
			'price' => null,
			'price_html' => '',
			'error' => 'Webhook вернул неподдерживаемый формат ответа.',
		);
	}

	foreach (array('price_html', 'priceHtml', 'formatted_price', 'formattedPrice', 'formattedAmount', 'formatted_amount') as $html_key) {
		if (!empty($response[$html_key])) {
			return array(
				'price' => $response['price'] ?? $response['total'] ?? $response['amount'] ?? null,
				'price_html' => (string) $response[$html_key],
				'error' => '',
			);
		}
	}

	foreach (array('price', 'total', 'amount', 'sum', 'value', 'cost', 'total_price', 'totalPrice', 'calculated_price', 'calculatedPrice') as $price_key) {
		if (isset($response[$price_key]) && '' !== $response[$price_key]) {
			return array(
				'price' => $response[$price_key],
				'price_html' => '',
				'error' => '',
			);
		}
	}

	foreach (array('data', 'result', 'body', 'json', 'output') as $nested_key) {
		if (isset($response[$nested_key])) {
			$nested_result = myprintlab_extract_price_from_webhook_response($response[$nested_key]);

			if (empty($nested_result['error']) && (null !== $nested_result['price'] || '' !== $nested_result['price_html'])) {
				return $nested_result;
			}
		}
	}

	if (isset($response[0])) {
		$first_result = myprintlab_extract_price_from_webhook_response($response[0]);

		if (empty($first_result['error']) && (null !== $first_result['price'] || '' !== $first_result['price_html'])) {
			return $first_result;
		}
	}

	if (!empty($response['message'])) {
		return array(
			'price' => null,
			'price_html' => '',
			'error' => (string) $response['message'],
		);
	}

	return array(
		'price' => null,
		'price_html' => '',
		'error' => 'Webhook не вернул цену. Ожидаются поля price_html, price, total или amount.',
	);
}
