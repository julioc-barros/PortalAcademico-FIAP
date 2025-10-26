<div class="toggle">
    <a href="#" class="burger js-menu-toggle">
        <i class="icon-default bi bi-list"></i>
        <i class="icon-active bi bi-x-lg"></i>
    </a>
</div>

<script>
    $(function () {
        'use strict';

        // Lógica do Toggle (Esta lógica já adiciona a classe '.active' no <a>)
        $('.js-menu-toggle').click(function (e) {
            e.preventDefault();
            var $this = $(this);
            if ($('body').hasClass('show-sidebar')) {
                $('body').removeClass('show-sidebar');
                $this.removeClass('active');
            } else {
                $('body').addClass('show-sidebar');
                $this.addClass('active');
            }
        });

        // Clique fora do menu
        $(document).mouseup(function (e) {
            var container = $(".sidebar");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                if ($('body').hasClass('show-sidebar')) {
                    $('body').removeClass('show-sidebar');
                    $('body').find('.js-menu-toggle').removeClass('active');
                }
            }
        });

        // Lógica do Accordion (Bootstrap 5)
        $('.collapsible').on('click', function(e) {
            e.preventDefault();
            var targetId = $(this).attr('data-bs-target'); 
            var $collapseTarget = $(targetId);
            var collapseInstance = bootstrap.Collapse.getOrCreateInstance($collapseTarget[0]);
            collapseInstance.toggle();
            var isExpanded = $(this).attr('aria-expanded') === 'true';
            $(this).attr('aria-expanded', !isExpanded);
        });
    });
</script>