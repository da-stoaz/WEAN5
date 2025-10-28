using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using PublicTransport.Data;
using PublicTransport.Entities;

namespace PublicTransport.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class TestController : ControllerBase
    {
        private readonly AppDbContext _context;

        public TestController(AppDbContext context)
        {
            _context = context;
        }

        // GET: api/Test
        [HttpGet]
        public async Task<ActionResult<IEnumerable<Entities.PublicTransportE>>> GetPublicTransports()
        {
            return await _context.PublicTransports.ToListAsync();
        }

        // GET: api/Test/5
        [HttpGet("{id}")]
        public async Task<ActionResult<Entities.PublicTransportE>> GetPublicTransport(int id)
        {
            var publicTransport = await _context.PublicTransports.FindAsync(id);

            if (publicTransport == null)
            {
                return NotFound();
            }

            return publicTransport;
        }

        // PUT: api/Test/5
        // To protect from overposting attacks, see https://go.microsoft.com/fwlink/?linkid=2123754
        [HttpPut("{id}")]
        public async Task<IActionResult> PutPublicTransport(int id, Entities.PublicTransportE publicTransportE)
        {
            if (id != publicTransportE.Id)
            {
                return BadRequest();
            }

            _context.Entry(publicTransportE).State = EntityState.Modified;

            try
            {
                await _context.SaveChangesAsync();
            }
            catch (DbUpdateConcurrencyException)
            {
                if (!PublicTransportExists(id))
                {
                    return NotFound();
                }
                else
                {
                    throw;
                }
            }

            return NoContent();
        }

        // POST: api/Test
        // To protect from overposting attacks, see https://go.microsoft.com/fwlink/?linkid=2123754
        [HttpPost]
        public async Task<ActionResult<Entities.PublicTransportE>> PostPublicTransport(Entities.PublicTransportE publicTransportE)
        {
            _context.PublicTransports.Add(publicTransportE);
            await _context.SaveChangesAsync();

            return CreatedAtAction("GetPublicTransport", new { id = publicTransportE.Id }, publicTransportE);
        }

        // DELETE: api/Test/5
        [HttpDelete("{id}")]
        public async Task<IActionResult> DeletePublicTransport(int id)
        {
            var publicTransport = await _context.PublicTransports.FindAsync(id);
            if (publicTransport == null)
            {
                return NotFound();
            }

            _context.PublicTransports.Remove(publicTransport);
            await _context.SaveChangesAsync();

            return NoContent();
        }

        private bool PublicTransportExists(int id)
        {
            return _context.PublicTransports.Any(e => e.Id == id);
        }
    }
}
