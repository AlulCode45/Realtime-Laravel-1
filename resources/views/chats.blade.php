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
                        <li class="list-group-item active">Andi</li>
                        <li class="list-group-item">Budi</li>
                        <li class="list-group-item">Cici</li>
                    </ul>
                </div>
            </div>

            <!-- Chat Area -->
            <div class="col-md-9 d-flex flex-column h-100">
                <!-- Header -->
                <div class="border-bottom p-3 bg-white">
                    <h5 class="mb-0">Chat dengan Andi</h5>
                </div>

                <!-- Chat Messages -->
                <div class="flex-grow-1 chat-box d-flex flex-column">
                    <div class="chat-message message-incoming">Halo, ada waktu ngobrol?</div>
                    <div class="chat-message message-outgoing">Hai! Boleh banget, ada apa?</div>
                    <div class="chat-message message-incoming">Lagi belajar NestJS nih, bantuin dong 😅</div>
                    <div class="chat-message message-outgoing">Siap, gaskeun 💪</div>

                    <!-- Typing indicator -->
                    <div class="typing-indicator">Andi sedang mengetik...</div>
                </div>

                <!-- Input -->
                <div class="border-top p-3 bg-white">
                    <form class="d-flex gap-2">
                        <input type="text" class="form-control" placeholder="Tulis pesan..." />
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>