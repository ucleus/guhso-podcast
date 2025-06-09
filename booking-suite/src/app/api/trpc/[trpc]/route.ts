import { fetchRequestHandler } from '@trpc/server/adapters/fetch';
import { router } from '@/server/routers/_app';
import { NextRequest } from 'next/server';

const handler = (req: NextRequest) =>
  fetchRequestHandler({
    endpoint: '/api/trpc',
    req,
    router,
    createContext: () => ({}),
  });

export { handler as GET, handler as POST };
