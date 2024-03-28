<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>


        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Book', 'icon' => 'fa-book', 'url' => ['/gii']],
                    ['label' => 'Category', 'icon' => 'fa-institution', 'url' => ['/debug']],
                    ['label' => 'Parser', 'icon' => 'fa-search', 'url' => ['/parser']],
                ],
            ]
        ) ?>

    </section>

</aside>
