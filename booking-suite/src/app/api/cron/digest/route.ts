import { NextResponse } from 'next/server';
import { prisma } from '@/server/db';

export async function GET() {
  // send digest email / SMS
  const upcoming = await prisma.booking.findMany({
    where: { status: 'PENDING' },
  });
  console.log('Digest', upcoming.length);
  return NextResponse.json({ ok: true });
}
