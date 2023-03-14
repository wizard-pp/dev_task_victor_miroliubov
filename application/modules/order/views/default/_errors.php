<?php if ($errors = Yii::$app->session->getFlash('errors')): ?>
    <div class="row-danger">
        <div class="color-danger">
            <?= Yii::t('order', 'error_message') ?>
            <ul>
                <?php foreach ($errors as $errorKey => $errorMessages): ?>
                    <li>
                        <b><?= Yii::t('order', 'error_message_for_attribute', [
                                'attribute' => $errorKey
                            ]) ?></b>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
