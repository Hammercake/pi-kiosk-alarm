<script>
$(function() {
	if (speechSynthesis.onvoiceschanged !== undefined) {
		speechSynthesis.onvoiceschanged = voice;
	}
	
	var runonce = false;
	
	function voice()
	{
		if (runonce) return;
		runonce = true;
		
		var lang = <?php echo json_encode($this->lang('lang')); ?>;
		var eve = new SpeechSynthesisUtterance();

		// TODO - When supporting other languages, loop in the voices and use the first that uses the wanted lang
		var voices = speechSynthesis.getVoices();
		var i;
		
		for (i in voices) {
			if (voices[i].lang == lang) {
				eve.voice = voices[i];
				break;
			}
		}

		eve.text = <?php echo json_encode($this->lang('goodday')); ?>;

		window.speechSynthesis.speak(eve);
	}
});
</script>