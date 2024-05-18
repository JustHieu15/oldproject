@extends('layouts.client')

@section('title')
    Do Test
@endsection

@section('content')
    <div class="container">
        @if (session('msg'))
            <div class="alert alert-success">{{ session('msg') }}</div>
        @endif

        <h2 class="text-center pt-4 pb-2 mb-3">{{ $getExam->name }}</h2>
        @php
            $index = 1;
        @endphp


        <form id="form-questions" action="{{ route('questions.complete', [$getExam->id, Auth::user()]) }}" method="post">
            @csrf

            <div class="row">
                <div class="col-6">
                    @foreach ($listQuestions as $question)
                        @if ($getExam->id == $question->exam_id)
                            <div class="col-md-12">
                                <p><span class="fw-bold">Question {{ $index++ }}: {{ $question->name }}</span>
                                </p>
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                                        id="choice{{ $question->id }}_1" value="A">
                                    <label class="form-check-label" for="choice{{ $question->id }}_1">
                                        {{ $question->option_a }}
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                                        id="choice{{ $question->id }}_2" value="B">
                                    <label class="form-check-label" for="choice{{ $question->id }}_2">
                                        {{ $question->option_b }}
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                                        id="choice{{ $question->id }}_3" value="C">
                                    <label class="form-check-label" for="choice{{ $question->id }}_3">
                                        {{ $question->option_c }}
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                                        id="choice{{ $question->id }}_4" value="D">
                                    <label class="form-check-label" for="choice{{ $question->id }}_4">
                                        {{ $question->option_d }}
                                    </label>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="col-6">
                    <h1 id="timer"></h1>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        window.addEventListener('beforeunload', function(event) {
            // Kiểm tra xem có dữ liệu trong LocalStorage không
            if (localStorage.getItem(storageKey + '_minutes') || localStorage.getItem(storageKey + '_seconds')) {
                let confirmationMessage = 'Bạn có chắc muốn rời khỏi trang?';
                (event || window.event).returnValue = confirmationMessage;
                return confirmationMessage;
            } else {
                // Xóa cảnh báo nếu không có dữ liệu trong LocalStorage
                delete(event || window.event).returnValue;
            }
        });

        // JavaScript countdown timer
        @php
            $seconds = $countdown;
            $minutes = floor($seconds / 60);
            $seconds_remainder = $seconds % 60;
        @endphp

        let countdownMinutes;
        let countdownSeconds;
        let timerDisplay = document.getElementById('timer');

        // Tạo một khóa duy nhất cho mỗi trang dựa trên địa chỉ URL
        let storageKey = 'countdown_' + window.location.href;

        function updateTimer() {
            let minutesStr = countdownMinutes < 10 ? '0' + countdownMinutes : countdownMinutes;
            let secondsStr = countdownSeconds < 10 ? '0' + countdownSeconds : countdownSeconds;

            timerDisplay.innerHTML = minutesStr + ":" + secondsStr + " remaining";

            if (countdownMinutes > 0 || countdownSeconds > 0) {
                if (countdownSeconds === 0) {
                    countdownMinutes--;
                    countdownSeconds = 59;
                } else {
                    countdownSeconds--;
                }

                // Store the updated values in LocalStorage with the unique key
                localStorage.setItem(storageKey + '_minutes', countdownMinutes.toString());
                localStorage.setItem(storageKey + '_seconds', countdownSeconds.toString());

                setTimeout(updateTimer, 1000);
            } else {
                // Clear the stored values when the countdown is complete
                localStorage.removeItem(storageKey + '_minutes');
                localStorage.removeItem(storageKey + '_seconds');

                document.querySelector('#form-questions').submit();
            }

            if (countdownMinutes < 1) {
                timerDisplay.classList.add('text-danger');
            }
        }

        // Function to update timer values from LocalStorage
        function updateTimerFromStorage() {
            let storedMinutes = localStorage.getItem(storageKey + '_minutes');
            let storedSeconds = localStorage.getItem(storageKey + '_seconds');

            countdownMinutes = storedMinutes !== null ? parseInt(storedMinutes) : @php echo $minutes; @endphp;
            countdownSeconds = storedSeconds !== null ? parseInt(storedSeconds) : @php echo $seconds_remainder; @endphp;

            updateTimer();
        }

        // Initial call to update timer values
        updateTimerFromStorage();

        // JavaScript add data to local storage
        let form = document.querySelector('#form-questions');
        let inputs = form.querySelectorAll('input[type="radio"]');
        let answers = localStorage.getItem('answers') == null ? [] : localStorage.getItem('answers');

        // Kiểm tra xem localStorage có khả dụng không
        if (typeof localStorage !== 'undefined') {
            // JavaScript add data to local storage
            for (let i = 0; i < inputs.length; i++) {
                let input = inputs[i];

                input.addEventListener('change', function(event) {
                    let input = event.target;
                    let questionId = input.name.replace('answers[', '').replace(']', '');
                    let answer = input.value;
                    let obj = {
                        questionId,
                        answer
                    }

                    answers.push(obj)
                    // Cập nhật local storage khi có sự thay đổi cụ thể
                    localStorage.setItem('answers', JSON.stringify(answers));
                });
            }

            // JavaScript get data from local storage

            if (answers.length > 0) {
                answers = JSON.parse(answers);

                for (let i = 0; i < answers.length; i++) {
                    let answer = answers[i];
                    let input = document.querySelector('input[name="answers[' + answer.questionId + ']"][value="' +
                        answer.answer + '"]');

                    if (input != null) {
                        input.checked = true;
                    }
                }
            }
        }

        document.querySelector('#form-questions').addEventListener('submit', function(event) {
            localStorage.removeItem('countdown_' + window.location.href + '_minutes');
            localStorage.removeItem('countdown_' + window.location.href + '_seconds');
            localStorage.removeItem('answers');
        });
    </script>
@endpush
