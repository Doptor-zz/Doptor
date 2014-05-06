<section id="widgets">
	<div class="container">

		<div class="grid_12">
			<!-- BEGIN NAV Widget -->
			<div class="widget widget-nav">
				{{ Services\MenuManager::generate('public-bottom-menu') }}
			</div>
			<!-- END NAV Widget -->
		</div>
	</div>
</section>

<!-- BEGIN FOOTER -->
<footer id="footer">
    <div class="container">
        <div class="grid_12">
            <small>{{ Setting::value('footer_text') }}</small>
        </div>
    </div>
</footer>
<!-- END FOOTER -->
