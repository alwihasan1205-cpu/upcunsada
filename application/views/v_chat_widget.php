<!-- Self-contained Premium Chat Widget -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<style>
    #chat-widget {
        position: fixed; bottom: 30px; right: 30px; z-index: 999999;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }
    #chat-bubble {
        width: 65px; height: 65px;
        background: linear-gradient(135deg, #FF3366, #9933FF);
        border-radius: 50%; display: flex; justify-content: center; align-items: center;
        cursor: pointer; box-shadow: 0 10px 30px rgba(255, 51, 102, 0.4);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 2px solid rgba(255, 255, 255, 0.2);
    }
    #chat-bubble:hover { transform: scale(1.1) rotate(5deg); }
    
    #chat-window {
        display: none; width: 380px; height: 600px;
        background: #fff; border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        flex-direction: column; overflow: hidden;
        position: absolute; bottom: 85px; right: 0;
        border: 1px solid rgba(0,0,0,0.05); transform-origin: bottom right;
        animation: chatOpen 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    @keyframes chatOpen { from { opacity: 0; transform: scale(0.8) translateY(20px); } to { opacity: 1; transform: scale(1) translateY(0); } }

    .chat-header {
        background: linear-gradient(135deg, #FF3366, #9933FF);
        padding: 25px 20px; color: white; display: flex;
        justify-content: space-between; align-items: center; position: relative;
    }
    .chat-header h5 { margin: 0; font-weight: 700; font-size: 1.1rem; }
    .chat-header .status-bar { display: flex; align-items: center; gap: 8px; font-size: 0.8rem; opacity: 0.8; margin-top: 4px; }
    .status-dot { width: 8px; height: 8px; background: #fff; border-radius: 50%; }

    .mode-switcher { padding: 15px 20px; background: #fff; border-bottom: 1px solid #f1f3f5; }
    .switch-pills { background: #f1f3f5; padding: 4px; border-radius: 50px; display: flex; }
    .switch-btn {
        flex: 1; border: none; padding: 10px; border-radius: 50px;
        font-size: 0.85rem; font-weight: 600; color: #666;
        background: transparent; transition: all 0.3s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .switch-btn.active { background: #fff; color: #FF3366; box-shadow: 0 4px 10px rgba(0,0,0,0.08); }

    #chat-body { flex: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 15px; background: #fff; }
    .msg { max-width: 85%; padding: 12px 16px; border-radius: 18px; font-size: 0.9rem; line-height: 1.5; }
    .msg-bot { background: #f1f3f5; color: #333; align-self: flex-start; border-bottom-left-radius: 4px; }
    .msg-user { background: #FF3366; color: white; align-self: flex-end; border-bottom-right-radius: 4px; box-shadow: 0 4px 12px rgba(255, 51, 102, 0.2); }
    .msg-admin { background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; align-self: flex-start; border-bottom-left-radius: 4px; }

    .chat-footer { padding: 15px 20px; background: white; border-top: 1px solid #f1f3f5; display: flex; gap: 12px; }
    .chat-input {
        border-radius: 50px; border: 1px solid #e9ecef; padding: 10px 20px; font-size: 0.9rem;
        transition: border-color 0.3s; width: 100%; outline: none;
    }
    .chat-input:focus { border-color: #FF3366; }
    .send-btn {
        width: 44px; height: 44px; border-radius: 50%; border: none;
        background: #FF3366; color: white; display: flex;
        align-items: center; justify-content: center; transition: all 0.3s; flex-shrink: 0;
    }
    .send-btn:hover { transform: scale(1.1); background: #9933FF; }

    #chat-reg-form { padding: 30px 20px; text-align: center; }
    .form-control-premium {
        border-radius: 12px; border: 1.5px solid #eee; padding: 12px 15px; margin-bottom: 15px;
        font-size: 0.95rem; width: 100%; transition: all 0.3s; box-sizing: border-box; outline: none;
    }
    .form-control-premium:focus { border-color: #FF3366; background: #fffafb; }
    .reg-btn {
        width: 100%; padding: 12px; background: #FF3366; color: white; border: none;
        border-radius: 12px; font-weight: 700; box-shadow: 0 4px 12px rgba(255, 51, 102, 0.2);
    }
</style>

<div id="chat-widget">
    <div id="chat-bubble">
        <i class="bi bi-chat-heart-fill text-white" style="font-size: 1.8rem;"></i>
    </div>

    <div id="chat-window">
        <div class="chat-header">
            <div>
                <h5>Asisten Virtual</h5>
                <div class="status-bar">
                    <div class="status-dot"></div> Online & Ready
                </div>
            </div>
            <i class="bi bi-dash-lg" id="close-chat" style="cursor: pointer; font-size: 1.5rem;"></i>
        </div>

        <div class="mode-switcher">
            <div class="switch-pills">
                <button id="mode-ai" class="switch-btn active"><i class="bi bi-robot"></i> Tanya AI</button>
                <button id="mode-admin" class="switch-btn"><i class="bi bi-person-fill"></i> Chat Admin</button>
            </div>
        </div>

        <div id="chat-body">
            <div class="msg msg-bot">
                Halo! ✨ Saya AI asisten Anda di <strong><?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?></strong>. Ada yang bisa saya bantu hari ini?
            </div>
        </div>

        <div id="chat-reg-form" style="display: none;">
            <i class="bi bi-headset" style="font-size: 3rem; color: #FF3366;"></i>
            <h6 style="margin-top: 15px; font-weight: 700;">Butuh bantuan manusia?</h6>
            <p style="font-size: 0.85rem; color: #666; margin-bottom: 25px;">Isi data agar admin kami dapat menghubungi Anda kembali.</p>
            <input type="text" id="user-name" class="form-control-premium" placeholder="Nama Lengkap">
            <input type="text" id="user-phone" class="form-control-premium" placeholder="No WhatsApp (Aktif)">
            <button id="start-admin-chat" class="reg-btn">Mulai Chat Dukungan</button>
        </div>

        <div class="chat-footer" id="chat-footer-area">
            <input type="text" id="chat-input" class="chat-input" placeholder="Tanyakan sesuatu...">
            <button id="send-msg" class="send-btn"><i class="bi bi-send-fill" style="margin-left: 3px;"></i></button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let chatMode = 'ai';
    
    // Persistence: Get or Create Chat User ID
    let chatUserId = localStorage.getItem('chat_user_id');
    if(!chatUserId) {
        chatUserId = 'usr_' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('chat_user_id', chatUserId);
    }

    // Load History on Start
    loadChatHistory();

    // Start Polling for Admin Replies
    setInterval(loadChatHistory, 3000);

    $('#chat-bubble').on('click', () => {
        $('#chat-window').fadeToggle().css('display', 'flex');
        scrollToBottom();
    });
    $('#close-chat').on('click', () => $('#chat-window').fadeOut());

    $('#mode-ai').on('click', function() {
        chatMode = 'ai';
        $('.switch-btn').removeClass('active');
        $(this).addClass('active');
        $('#chat-reg-form').hide();
        $('#chat-body, #chat-footer-area').show();
        scrollToBottom();
    });

    $('#mode-admin').on('click', function() {
        chatMode = 'admin';
        $('.switch-btn').removeClass('active');
        $(this).addClass('active');
        
        let userName = localStorage.getItem('chat_user_name');
        if(!userName) {
            $('#chat-body, #chat-footer-area').hide();
            $('#chat-reg-form').fadeIn();
        } else {
            $('#chat-reg-form').hide();
            $('#chat-body, #chat-footer-area').show();
            scrollToBottom();
        }
    });

    $('#start-admin-chat').on('click', function() {
        const name = $('#user-name').val();
        const phone = $('#user-phone').val();
        if(name && phone) {
            localStorage.setItem('chat_user_name', name);
            localStorage.setItem('chat_user_phone', phone);
            
            $('#chat-reg-form').hide();
            $('#chat-body, #chat-footer-area').fadeIn();
            appendMessage(`Terima kasih <strong>${name}</strong>! Pesan Anda telah diteruskan ke admin. Mohon tunggu balasan kami.`, 'bot');
        } else {
            alert('Mohon isi Nama dan Nomor HP Anda.');
        }
    });

    $('#send-msg').on('click', sendMessage);
    $('#chat-input').on('keypress', function(e) { if(e.which == 13) sendMessage(); });

    function sendMessage() {
        const msg = $('#chat-input').val();
        if(!msg) return;

        appendMessage(msg, 'user');
        $('#chat-input').val('');

        if(chatMode === 'ai') {
            $.post('<?= base_url('chat/ask_ai') ?>', { 
                message: msg,
                chat_user_id: chatUserId 
            }, function(data) {
                try {
                    const res = JSON.parse(data);
                    appendMessage(res.reply, 'bot');
                } catch(e) {
                    appendMessage('Maaf, saya sedang mengalami gangguan dalam berpikir. Coba lagi ya!', 'bot');
                }
            });
        } else {
            const name = localStorage.getItem('chat_user_name');
            const phone = localStorage.getItem('chat_user_phone');
            $.post('<?= base_url('chat/send_to_admin') ?>', { 
                message: msg, 
                name: name, 
                phone: phone, 
                chat_user_id: chatUserId 
            });
        }
    }

    function appendMessage(text, sender) {
        let cls = sender === 'user' ? 'msg-user' : (sender === 'admin' ? 'msg-admin' : 'msg-bot');
        $('#chat-body').append(`<div class="msg ${cls}">${text}</div>`);
        scrollToBottom();
    }

    function scrollToBottom() {
        $('#chat-body').animate({ scrollTop: $('#chat-body')[0].scrollHeight }, 300);
    }

    function loadChatHistory() {
        $.getJSON('<?= base_url('chat/check_new_messages') ?>', { chat_user_id: chatUserId }, function(chats) {
            const currentMsgs = $('#chat-body .msg').length;
            // Only update UI if there are NEW messages
            if(chats.length > currentMsgs || (currentMsgs === 1 && chats.length > 0)) {
                // Keep the initial greeting
                const greeting = $('#chat-body .msg').first().prop('outerHTML');
                $('#chat-body').empty().append(greeting);
                
                chats.forEach(c => {
                    appendMessage(c.message, c.sender);
                });
            }
        });
    }
});
</script>
