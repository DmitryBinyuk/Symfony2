$(document).ready(function(){
	
	// Запускаем метод init, когда документ будет готов:
	chat.init();
	
});

var chat = {
	
	// data содержит переменные для использования в классах:
	
	data : {
		lastID 		: 0,
		noActivity	: 0
	},
	
	// Init привязывает обработчики событий и устанавливает таймеры:
	
	init : function(){
		
		// Используем плагин jQuery defaultText, включенный внизу:
		$('#name').defaultText('Псевдоним');
		$('#email').defaultText('Email (используется Gravatar)');
		
		// Конвертируем div #chatLineHolder в jScrollPane,
		// сохраняем API плагина в chat.data:
		
		chat.data.jspAPI = $('#chatLineHolder').jScrollPane({
			verticalDragMinHeight: 12,
			verticalDragMaxHeight: 12
		}).data('jsp');
		
		// Используем переменную working для предотвращения
		// множественных отправок формы:
		
		var working = false;
		
		// Регистрируем персону в чате:
		
		$('#loginForm').submit(function(){
			
			if(working) return false;
			working = true;
			
			// Используем нашу функцию tzPOST
			// (определяется внизу):
			
			$.tzPOST('login',$(this).serialize(),function(r){
				working = false;
				
				if(r.error){
					chat.displayError(r.error);
				}
				else chat.login(r.name,r.gravatar);
			});
			
			return false;
		});
        }
    }