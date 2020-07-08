<script>
    window.onload = function() {
        //likes
        document.querySelectorAll('.like-btn').forEach(item => {
            item.addEventListener('click', () => {
                let id = item.closest('.feed-item').getAttribute('data-id');
                let count = parseInt(item.innerText);
                if (item.classList.contains('on') === false) {
                    item.classList.add('on');
                    item.innerText = ++count;
                } else {
                    item.classList.remove('on');
                    item.innerText = --count;
                }

                fetch('ajax_like.php?id=' + id);
            });
        });
        //comentarios
        document.querySelectorAll('.fic-item-field').forEach(item => {
            item.addEventListener('keyup', async (e) => {
                if (e.keyCode == 13) {
                    let id = item.closest('.feed-item').getAttribute('data-id');
                    let txt = item.value;
                    item.value = '';

                    let data = new FormData();
                    data.append('id', id);
                    data.append('txt', txt);

                    let req = await fetch('ajax_comment.php', {
                        method: 'POST',
                        body: data
                    });
                    let json = await req.json();

                    if (json.error == '') {
                        let html = '<div class="fic-item row m-height-10 m-width-20">';
                        html += '<div class="fic-item-photo">';
                        html += '<a href="' + json.link + '"><img src="' + json.avatar + '" /></a>';
                        html += '</div>';
                        html += '<div class="fic-item-info">';
                        html += '<a href="' + json.link + '">' + json.name + '</a>';
                        html += json.body;
                        html += '</div>';
                        html += '</div>';

                        item.closest('.feed-item')
                            .querySelector('.feed-item-comments-area')
                            .innerHTML += html;
                    }

                }
            });
        });

        //upload of photos

        // let feedPhoto = document.querySelector('.feed-new-photo');
        // let feedFile = document.querySelector('.feed-new-file');

        // feedPhoto.addEventListener('click', function() {
        //     feedFile.click();
        // });
        // feedFile.addEventListener('change', async function() {
        //     let photo = feedFile.files[0];
        //     let formData = new FormData();

        //     formData.append('photo', photo);
        //     let req = await fetch('ajax_upload.php', {
        //         method: 'POST',
        //         body: formData
        //     });
        //     let json = await req.json();

        //     if (json.error != '') {
        //         alert(json.error);
        //     }

        //     window.location.href = window.location.href;
        // });
    };
</script>