import { prisma } from '../db';
import { initTRPC } from '@trpc/server';

const t = initTRPC.create();

export const serviceRouter = t.router({
  list: t.procedure.query(() => prisma.service.findMany()),
});
