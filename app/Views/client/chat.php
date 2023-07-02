<?= $this->extend('components/layout') ?>

<?= $this->section('body') ?>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 pt-3 pb-3 bg-white from-wrapper">
                <div class="container">
                    <h3>Chat</h3>
                    <hr>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-4 mb-3">
                            <ul id="user-list" class="list-group"></ul>
                        </div>
                        <div class="col-12 col-sm-12 col-md-8">
                            <div class="row">
                                <div class="col-12">
                                    <div class="message-holder">
                                        <div id="messages" class="row"></div>
                                    </div>
                                    <div class="form-group">
                                        <textarea id="message-input" class="form-control" name="" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button id="send" class="btn float-right  btn-primary">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const clientCommands = {
            'add_user': 'add_user',
            'remove_user': 'remove_user',
            'add_message': 'add_message',
            'add_all_messages': 'add_all_messages',
        };
        const serverCommands = {
            'msg': 'msg',
        };
        $(function () {
            scrollMsgBottom()
        })

        function scrollMsgBottom() {
            var d = $('.message-holder');
            d.scrollTop(d.prop("scrollHeight"));
        }

        $(function () {
            var conn = new WebSocket("<?=config('App')->baseSocketURL?>?access_token=<?= session()->get('jwt_token') ?>");
            conn.onopen = function (e) {
                console.log("Connection established!");
            };

            conn.onmessage = function (e) {
                console.log(e.data);

                var data = JSON.parse(e.data)
                if (data['command'] === clientCommands['add_user']) {
                    addUser(data['user'])
                } else if (data['command'] === clientCommands['remove_user']) {
                    removeUser(data['user'])
                } else if (data['command'] === clientCommands['add_message']) {
                    addMessage(data['msg'], data['full_name'], data['time'])
                } else if (data['command'] === clientCommands['add_all_messages']) {
                    addAllMessages(data['messages'])
                }
            };

            $('#send').on('click', function () {
                var msg = $('#message-input').val()
                if (msg.trim() == '')
                    return false
                var data = JSON.stringify({
                    'command': serverCommands['msg'],
                    'msg': msg,
                })
                conn.send(data);
                myMessage(msg)
                $('#message-input').val('')
            })
        })

        function myMessage(msg, date = null) {
            if (date == null) {
                date = new Date;
                var minutes = date.getMinutes();
                var hour = date.getHours();
                var day = date.getMinutes();
                var month = date.getHours();
                var year = date.getHours();
                date = year + '-' + month + '-' + day + ' ' + hour + ':' + minutes
            }
            var html = `<div class="col-8 msg-item right-msg offset-4">
                    <div class="msg-img">
                      <img class="img-thumbnail rounded-circle" src="/assets/img/user_profile.png">
                    </div>
                    <div class="msg-text">
                      <span class="author">Me</span> <span class="time">` + date + `</span><br>
                      <p>` + msg + `</p>
                    </div>
                  </div>`
            $('#messages').append(html)
            scrollMsgBottom()
        }

        function addUser(user) {
            console.log(user)
            var html = `<li class="list-group-item btn mb-2 bg-secondary text-white" id=` + user['user_id'] + '>' + user['full_name'] + '</li>'
            $('#user-list').prepend(html)
        }

        function removeUser(user) {
            $(`#${user['user_id']}`).remove()
        }

        function addMessage(message, from, time) {
            html = ` <div class="col-8 msg-item left-msg" >
                            <div class="msg-img" ><img class="img-thumbnail rounded-circle"
                        src = "/assets/img/user_profile.png" >
                            </div>
                        <div class="msg-text">
                            <span class="author">` + from + `</span> <span class="time">` + time + `</span><br>
                            <p>` + message + `</p>
                        </div>
                    </div>`
            $('#messages').append(html)
            scrollMsgBottom()
        }

        function addAllMessages(messages) {
            for (let i = 0; i < messages.length; i++) {
                if (messages[i]['from_user_id'] === '<?= session()->get('id') ?>') {
                    myMessage(messages[i]['message'], messages[i]['created_at'])
                }
                else {
                    addMessage(
                        messages[i]['message'],
                        messages[i]['full_name'],
                        messages[i]['created_at'],
                    )
                }
            }
        }
    </script>


<?= $this->endSection() ?>