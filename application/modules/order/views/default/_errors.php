<?php if ($errors = Yii::$app->session->getFlash('errors')): ?>
    <div class="row-danger">
        <div class="color-danger">
            <?= Yii::t('app', 'An error has occurred.') ?>
            <ul>
                <?php foreach ($errors as $errorKey => $errorMessages): ?>
                    <li>
                        <b><?= Yii::t('app', $errorKey) ?></b>
                        <ul>
                            <?php foreach ($errorMessages as $errorMessage): ?>
                                <li><?= Yii::t('app', $errorMessage) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
