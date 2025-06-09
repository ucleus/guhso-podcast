import { NextRequest, NextResponse } from 'next/server';
import { prisma } from '@/server/db';

export async function POST(req: NextRequest) {
  const event = await req.json();
  if (event.type === 'payment.updated') {
    const { bookingId } = event.data.object.metadata;
    await prisma.booking.update({
      where: { id: bookingId },
      data: { status: 'CONFIRMED' },
    });
  }
  return NextResponse.json({ ok: true });
}
