'use client';
import Calendar from '@/components/Calendar';

export default function BookingPage() {
  return (
    <main className="p-4">
      <h1 className="text-xl font-semibold mb-4">Book an Appointment</h1>
      <Calendar />
    </main>
  );
}
