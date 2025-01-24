@if(session('success'))
    <div id="flash-message" class="alert alert-success" style="position: absolute; top: 10px; right: 10px; padding: 10px 20px; background2:linear-gradient(135deg, #34b7f1, #4caf50);background: linear-gradient(135deg, rgb(50 150 50 / 82%), rgb(126 199 126));
 color: white; border-radius: 5px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div id="flash-message" class="alert alert-success" style="position: absolute; top: 10px; right: 10px; padding: 10px 20px; background:linear-gradient(135deg, #f44336, #d32f2f); color: white; border-radius: 5px;">
        {{ session('success') }}
    </div>
@endif

<style>
#flash-message {
    position: fixed;
    top: 10px;
    right: 10px;
	margin-top:4%;
    padding: 10px 20px; 
    color: white;
    border-radius: 5px;
    z-index: 9999;
    font-size: 16px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: opacity 0.5s ease;
}

#flash-message.hide {
    opacity: 0;
    visibility: hidden;
}
</style>

@if(session('success'))
	<script>
		window.setTimeout(function() {
			var flashMessage = document.getElementById('flash-message');
			if (flashMessage) {
				flashMessage.style.display = 'none';
			}
		}, 7000);
	</script>
@endif
