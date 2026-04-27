<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Payments 💰</h1>

        <table class="w-full bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th>User</th>
                    <th>Course</th>
                    <th>Amount</th>
                </tr>
            </thead>

            <tbody>
                @foreach($payments as $payment)
                    <tr class="border-b text-center">
                        <td>{{ $payment->user->name }}</td>
                        <td>{{ $payment->course->title }}</td>
                        <td>${{ $payment->amount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>