
<div>
    <div>
        <div>
            <div>
                <h1>회원 가입</h1>
                <div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div>
                            <label for="name">이름</label>
                            <div>
                                <input id="name" type="text"  name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span  role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="nickName">별명</label>

                            <div>
                                <input id="nickName" type="text"  name="nickName" value="{{ old('nickName') }}" required autocomplete="name" autofocus>

                                @error('nickName')
                                    <span  role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="password">비밀번호</label>

                            <div>
                                <input id="password" type="password"  name="password" required autocomplete="new-password">

                                @error('password')
                                    <span  role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="phoneNumber">전화번호</label>

                            <div>
                                <input id="password" type="password"  name="phoneNumber" required autocomplete="new-password">

                                @error('phoneNumber')
                                    <span  role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="email">이메일</label>

                            <div>
                                <input id="email" type="email"  name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span  role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="성별">성별</label>

                            <div>
                                <input id="gender" type="radio"  name="gender" value="male">
                                <label for="male">남자</label>
                                <input id="gender" type="radio"  name="gender" value="female">
                                <label for="female">여자</label>
                                
                            </div>
                        </div>

                        <div>
                            <div>
                                <button type="submit">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>