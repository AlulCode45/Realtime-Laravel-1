<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chat App Layout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            overflow: hidden;
        }

        .chat-box {
            height: calc(100vh - 56px - 70px);
            overflow-y: auto;
            padding: 15px;
            background: #f8f9fa;
        }

        .message-incoming {
            background: #e9ecef;
            align-self: flex-start;
        }

        .message-outgoing {
            background: #0d6efd;
            color: white;
            align-self: flex-end;
        }

        .chat-message {
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 20px;
            margin-bottom: 10px;
        }

        .typing-indicator {
            font-style: italic;
            font-size: 0.9em;
            color: gray;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <!-- Sidebar -->
            <div class="col-md-3 border-end d-none d-md-block bg-light">
                <div class="p-3">
                    <h5>Teman</h5>
                    <ul class="list-group">
                        @foreach ($users as $u)
                            <a href="{{ route('chat.view', $u->id) }}"
                                class="list-group-item {{ $u->id == $receiver->id ? 'active' : '' }}">
                                {{ $u->name }}
                            </a>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Chat Area -->
            <div class="col-md-9 d-flex flex-column h-100">
                <!-- Header -->
                <div class="border-bottom p-3 bg-white">
                    <h5 class="mb-0">Chat dengan {{ $receiver->name }}</h5>
                </div>

                <!-- Chat Messages -->
                <div id="chat-box" class="flex-grow-1 chat-box d-flex flex-column">
                    <!-- Chat messages will be appended here -->
                </div>

                <!-- Input -->
                <div class="border-top p-3 bg-white">
                    <form id="chat-form" class="d-flex gap-2">
                        <input type="text" id="message" class="form-control" placeholder="Tulis pesan..."
                            autocomplete="off" />
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Laravel Echo & Chat Script -->
    @vite(['resources/js/app.js'])
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const userId = {{ auth()->user()->id }};
            const receiverId = {{ $receiver->id }};

            const chatBox = document.getElementById('chat-box');
            const chatForm = document.getElementById('chat-form');
            const messageInput = document.getElementById('message');

            // Load previous chats
            fetch(`/chats?user_id=${receiverId}`)
                .then(res => res.json())
                .then(chats => {
                    chats.forEach(chat => {
                        appendMessage(chat.message, chat.sender_id === userId);
                    });
                });

            // Submit message
            chatForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const message = messageInput.value.trim();
                if (!message) return;

                appendMessage(message, true);

                fetch('/chats', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        receiver_id: receiverId,
                        message: message
                    })
                });

                messageInput.value = '';
            });

            // Listen real-time message
            if (window.Echo) {
                console.log("👀 Listening to: chat." + userId);
                window.Echo.private(`chat.${userId}`)
                    .listen('ChatSent', (e) => {
                        console.log('📩 New message received:', e);
                        if (e.sender_id === receiverId) {
                            appendMessage(e.message, false);
                        }
                    });
            } else {
                console.error('❌ window.Echo belum terdefinisi');
            }

            function appendMessage(message, isOutgoing) {
                const msgDiv = document.createElement('div');
                msgDiv.classList.add('chat-message');
                msgDiv.classList.add(isOutgoing ? 'message-outgoing' : 'message-incoming');
                msgDiv.innerText = message;
                chatBox.appendChild(msgDiv);
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>