<div class="row">
    <!-- Chat List -->
    <div class="col-md-4">
        <div class="card mb-4" style="height: 70vh;">
            <div class="card-header fw-bold">Daftar Antrean Chat</div>
            <div class="list-group list-group-flush overflow-auto">
                <?php if(empty($sessions)): ?>
                    <div class="p-4 text-center text-muted small">Belum ada chat masuk.</div>
                <?php endif; ?>
                <?php foreach($sessions as $s): ?>
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action p-3 chat-session" data-session="<?= $s->session_id ?>" data-name="<?= $s->name ?>">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1"><?= $s->name ?></h6>
                            <small class="text-muted"><?= date('H:i', strtotime($s->last_chat)) ?></small>
                        </div>
                        <p class="mb-1 small text-truncate"><?= $s->phone ?></p>
                        <?php 
                            $unread = $this->db->get_where('tb_chats', ['session_id' => $s->session_id, 'is_read' => 0, 'sender' => 'user'])->num_rows();
                            if($unread > 0) echo '<span class="badge bg-danger">'.$unread.' unread</span>';
                        ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Chat Box -->
    <div class="col-md-8">
        <div class="card mb-4" id="chat-box-container" style="display: none; height: 70vh;">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span id="active-user-name">Chatting...</span>
                <i class="bi bi-person-fill"></i>
            </div>
            <div class="card-body overflow-auto" id="chat-messages" style="background: #f0f2f5;">
                <!-- Messages will appear here -->
            </div>
            <div class="card-footer p-3 bg-white">
                <form id="reply-form" class="d-flex gap-2">
                    <input type="hidden" id="active-session-id">
                    <input type="text" class="form-control" id="reply-message" placeholder="Ketik balasan..." required>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i></button>
                </form>
            </div>
        </div>
        <div id="no-chat-selected" class="card h-100 d-flex justify-content-center align-items-center text-muted border-0 bg-transparent">
            <div><i class="bi bi-chat-quote fs-1"></i></div>
            <p>Pilih salah satu sesi di samping untuk mulai membalas chat.</p>
        </div>
    </div>
</div>

<style>
    .message-bubble { max-width: 75%; padding: 10px 15px; border-radius: 15px; margin-bottom: 10px; clear: both; position: relative; }
    .msg-user { background: white; col: black; float: left; border-bottom-left-radius: 2px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    .msg-admin { background: #0084ff; color: white; float: right; border-bottom-right-radius: 2px; }
    .msg-time { font-size: 0.7rem; opacity: 0.6; display: block; margin-top: 5px; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentSession = null;
    let refreshInterval = null;

    $('.chat-session').on('click', function() {
        const sessionId = $(this).data('session');
        const userName = $(this).data('name');
        
        currentSession = sessionId;
        $('#active-session-id').val(sessionId);
        $('#active-user-name').text('Sedang chat dengan: ' + userName);
        $('#chat-box-container').show();
        $('#no-chat-selected').hide();
        
        loadChatHistory(sessionId);
        
        // Polling for new messages
        if(refreshInterval) clearInterval(refreshInterval);
        refreshInterval = setInterval(() => loadChatHistory(sessionId), 3000);
    });

    function loadChatHistory(sessionId) {
        $.getJSON('<?= base_url('admin/get_chat_history/') ?>' + sessionId, function(chats) {
            let html = '';
            chats.forEach(chat => {
                const alignClass = chat.sender === 'user' ? 'msg-user' : 'msg-admin';
                html += `
                    <div class="message-bubble ${alignClass}">
                        <div>${chat.message}</div>
                        <span class="msg-time">${chat.created_at}</span>
                    </div>
                `;
            });
            $('#chat-messages').html(html);
            $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
        });
    }

    $('#reply-form').on('submit', function(e) {
        e.preventDefault();
        const msg = $('#reply-message').val();
        const sid = $('#active-session-id').val();

        $.post('<?= base_url('admin/send_chat_reply') ?>', { session_id: sid, message: msg }, function() {
            $('#reply-message').val('');
            loadChatHistory(sid);
        });
    });
});
</script>
