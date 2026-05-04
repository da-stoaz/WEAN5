@extends("layouts.app")

@section("title", "Hello Crate page")


@section("content")

    <form method="POST" action="{{ route('drivers.store') }}">
        @csrf

        <div class="flex flex-col gap-4 p-4">

           <div>
               <label for="name">Name</label>
               <input id="name" type="text" name="name" class="border rounded-md" />
               @error('name')<div class="text-sm text-red-500  inline-error">{{$message}}</div>  @enderror
           </div>

            <div>
                <label for="ssn">SSN</label>
                <input id="ssn" type="text" name="ssn" class="border rounded-md"/>
                @error('ssn')<div class="inline-error">{{$message}}</div>  @enderror
            </div>

            <div>
                <label for="birthdate">Birthdate</label>
                <input id="birthdate" type="date" name="birthdate" class="border rounded-md"/>
                @error("birthdate")<div class="inline-error">{{$message}}</div> @enderror
            </div>

            <div>
                <input class="border p-2 rounded-md" type="submit" value="Submit">

            </div>

        </div>
    </form>
@endsection

